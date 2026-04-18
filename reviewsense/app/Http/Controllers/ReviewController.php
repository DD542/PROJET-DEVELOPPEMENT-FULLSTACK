<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Services\SentimentService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private SentimentService $ai) {}

    public function index()
    {
        $reviews = Review::with('user:id,name,email')
            ->latest()
            ->paginate(20);

        return response()->json($reviews);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'content' => 'required|string|min:5|max:2000',
        ]);

        $analysis = $this->ai->analyze($data['content']);

        $review = Review::create([
            'user_id'   => $request->user()->id,
            'content'   => $data['content'],
            'sentiment' => $analysis['sentiment'],
            'score'     => $analysis['score'],
            'topics'    => $analysis['topics'],
        ]);

        return response()->json($review->load('user:id,name,email'), 201);
    }

    public function show(Review $review)
    {
        return response()->json($review->load('user:id,name,email'));
    }

    public function update(Request $request, Review $review)
    {
        if ($request->user()->id !== $review->user_id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $data = $request->validate([
            'content' => 'required|string|min:5|max:2000',
        ]);

        $analysis = $this->ai->analyze($data['content']);

        $review->update([
            'content'   => $data['content'],
            'sentiment' => $analysis['sentiment'],
            'score'     => $analysis['score'],
            'topics'    => $analysis['topics'],
        ]);

        return response()->json($review->load('user:id,name,email'));
    }

    public function destroy(Request $request, Review $review)
    {
        if ($request->user()->id !== $review->user_id && $request->user()->role !== 'admin') {
            return response()->json(['message' => 'Non autorisé.'], 403);
        }

        $review->delete();

        return response()->json(['message' => 'Avis supprimé.']);
    }

    public function analyze(Request $request)
    {
        $data = $request->validate([
            'text' => 'required|string|min:3',
        ]);

        $result = $this->ai->analyze($data['text']);

        return response()->json($result);
    }
}