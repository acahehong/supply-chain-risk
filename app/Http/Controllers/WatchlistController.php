<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use Illuminate\Support\Facades\Auth;

class WatchlistController extends Controller
{
    public function index()
    {
        $watchlists = Watchlist::with([
            'country.riskScores'
        ])
        ->where('user_id', Auth::id())
        ->get();

        $total = $watchlists->count();

        $high = 0;
        $medium = 0;
        $low = 0;

        foreach ($watchlists as $item) {

            $risk = optional($item->country->riskScores->last())->risk_level;

            if ($risk == 'High') {

                $high++;

            } elseif ($risk == 'Medium') {

                $medium++;

            } else {

                $low++;

            }
        }

        return view('watchlists.index', compact(
            'watchlists',
            'total',
            'high',
            'medium',
            'low'
        ));
    }

    public function store($country)
    {
        Watchlist::firstOrCreate([
            'user_id' => Auth::id(),
            'country_id' => $country,
        ]);

        return back()->with('success', 'Country added to watchlist.');
    }

    public function destroy($id)
    {
        Watchlist::where('id', Auth::id())
            ->orWhere(function($q) use ($id){
                $q->where('id',$id)
                  ->where('user_id',Auth::id());
            })
            ->delete();

        return back()->with('success','Removed from watchlist.');
    }
}