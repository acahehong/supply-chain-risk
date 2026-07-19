<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\NewsCache;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    /**
     * Menampilkan berita yang sudah tersimpan di database
     */
    public function index()
    {
        $news = NewsCache::with('country')
            ->latest('published_at')
            ->paginate(20);

        return view('news.index', compact('news'));
    }

    /**
     * Sinkronisasi berita dari News API
     */
    public function sync()
    {
        // Ambil hanya negara yang memiliki shipment
        $countries = Country::has('ports')->get();

        foreach ($countries as $country) {

            $response = Http::timeout(10)->get(
                'https://newsapi.org/v2/everything',
                [
                    'q' => '"' . $country->name . '" AND (port OR shipping OR logistics OR "supply chain")',
                    'language' => 'en',
                    'sortBy' => 'publishedAt',
                    'pageSize' => 5,
                    'apiKey' => env('NEWS_API_KEY'),
                ]
            );

            if (!$response->successful()) {
                continue;
            }

            $articles = $response->json()['articles'] ?? [];

            foreach ($articles as $article) {

                NewsCache::updateOrCreate(

                    [
                        'url' => $article['url'],
                    ],

                    [
                        'country_id'   => $country->id,
                        'title'        => substr($article['title'] ?? '', 0, 500),
                        'description'  => $article['description'],
                        'source'       => $article['source']['name'] ?? null,
                        'published_at' => $article['publishedAt'],
                        'fetched_at'   => now(),
                    ]

                );
            }
        }

        return redirect()
            ->route('news.index')
            ->with('success', 'News synchronized successfully.');
    }
}