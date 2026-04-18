<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $total = Review::count();

        $sentiments = Review::select('sentiment', DB::raw('count(*) as count'))
            ->groupBy('sentiment')
            ->pluck('count', 'sentiment');

        $positive = $sentiments['positive'] ?? 0;
        $neutral  = $sentiments['neutral']  ?? 0;
        $negative = $sentiments['negative'] ?? 0;

        $avgScore = Review::avg('score');

        // Top 3 thèmes
        $allTopics = Review::whereNotNull('topics')->pluck('topics')->flatten();
        $topTopics = $allTopics->countBy()->sortDesc()->take(3)->keys()->values();

        $recent = Review::with('user:id,name,email')
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'total'              => $total,
            'average_score'      => round($avgScore ?? 0),
            'sentiment_breakdown' => [
                'positive' => $positive,
                'neutral'  => $neutral,
                'negative' => $negative,
                'positive_pct' => $total > 0 ? round($positive / $total * 100) : 0,
                'negative_pct' => $total > 0 ? round($negative / $total * 100) : 0,
            ],
            'top_topics' => $topTopics,
            'recent_reviews' => $recent,
        ]);
    }
}