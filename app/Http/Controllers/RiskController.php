<?php

namespace App\Http\Controllers;

use App\Models\RiskScore;

class RiskController extends Controller
{
    public function index()
    {
        $risks = RiskScore::with('country')
            ->orderByDesc('total_score')
            ->get();

        $high = $risks->where('risk_level', 'High')->count();

        $medium = $risks->where('risk_level', 'Medium')->count();

        $low = $risks->where('risk_level', 'Low')->count();

        return view('risk.index', compact(
            'risks',
            'high',
            'medium',
            'low'
        ));
    }
}