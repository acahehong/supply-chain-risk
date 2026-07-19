<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\NewsCache;
use App\Services\SentimentService;

class AnalyzeNewsSentiment extends Command
{
    protected $signature = 'news:analyze';

    protected $description = 'Analyze sentiment of news articles';

    public function handle(SentimentService $sentiment)
    {
        $articles = NewsCache::all();

        foreach ($articles as $article) {

            $text = $article->title . ' ' . ($article->description ?? '');

            $score = $sentiment->analyze($text);

            // Simpan sentiment score
            $article->sentiment_score = $score;
            $article->save();

            $this->info(
                "{$article->title} => {$score}"
            );
        }

        $this->info('News sentiment analyzed successfully!');
    }
}