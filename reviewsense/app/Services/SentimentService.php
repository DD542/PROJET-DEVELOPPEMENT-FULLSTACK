<?php

namespace App\Services;

class SentimentService
{
    private array $positiveWords = [
        'excellent', 'parfait', 'super', 'génial', 'rapide', 'top', 'bravo',
        'satisfait', 'recommande', 'qualité', 'impeccable', 'merci', 'bien',
        'bon', 'bonne', 'content', 'ravie', 'ravie', 'agréable', 'conforme',
        'great', 'perfect', 'fast', 'good', 'love', 'best', 'amazing',
        'happy', 'satisfied', 'wonderful', 'fantastic', 'nice', 'efficient',
    ];

    private array $negativeWords = [
        'mauvais', 'nul', 'horrible', 'décevant', 'lent', 'problème', 'cassé',
        'inexistant', 'honte', 'arnaque', 'remboursement', 'jamais', 'pire',
        'catastrophe', 'déçu', 'déçue', 'défectueux', 'inutile', 'impossible',
        'bad', 'terrible', 'awful', 'broken', 'worst', 'poor', 'useless',
        'disappointed', 'never', 'horrible', 'waste', 'scam', 'defective',
    ];

    private array $topicKeywords = [
        'livraison'      => ['livraison', 'délai', 'retard', 'expédition', 'colis', 'reçu', 'delivery', 'shipping', 'arrived'],
        'qualité'        => ['qualité', 'solide', 'fragile', 'matière', 'durable', 'quality', 'material', 'build'],
        'prix'           => ['prix', 'cher', 'rapport', 'coût', 'tarif', 'price', 'expensive', 'cheap', 'value'],
        'service client' => ['service', 'support', 'réponse', 'contact', 'remboursement', 'customer', 'refund'],
        'emballage'      => ['emballage', 'packaging', 'boîte', 'carton', 'box', 'wrapped'],
        'rapidité'       => ['rapide', 'vite', 'immédiat', 'express', 'fast', 'quick', 'speed'],
    ];

    public function analyze(string $text): array
    {
        $words = $this->tokenize($text);

        $posCount = $this->countMatches($words, $this->positiveWords);
        $negCount = $this->countMatches($words, $this->negativeWords);
        $topics   = $this->detectTopics($words);
        $score    = $this->computeScore($text, $posCount, $negCount);
        $sentiment = $this->determineSentiment($posCount, $negCount, $score);

        return [
            'sentiment' => $sentiment,
            'score'     => $score,
            'topics'    => $topics,
        ];
    }

    private function tokenize(string $text): array
    {
        $text = mb_strtolower($text);
        $text = preg_replace('/[^\w\s]/u', ' ', $text);
        return preg_split('/\s+/', trim($text), -1, PREG_SPLIT_NO_EMPTY);
    }

    private function countMatches(array $words, array $list): int
    {
        return count(array_intersect($words, $list));
    }

    private function detectTopics(array $words): array
    {
        $found = [];
        foreach ($this->topicKeywords as $topic => $keywords) {
            if (array_intersect($words, $keywords)) {
                $found[] = $topic;
            }
        }
        return $found;
    }

    private function computeScore(string $text, int $pos, int $neg): int
    {
        $length     = min(strlen($text) / 10, 15);
        $sentiment  = ($pos - $neg) * 12;
        $exclamation = substr_count($text, '!') * 3;
        $base       = 50 + $sentiment + $length + $exclamation;

        return max(0, min(100, (int) round($base)));
    }

    private function determineSentiment(int $pos, int $neg, int $score): string
    {
        if ($score >= 65) return 'positive';
        if ($score <= 35) return 'negative';
        return 'neutral';
    }
}