<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CurrencyCache;

class CurrencyController extends Controller
{
    public function index()
    {
        return response()->json(

            CurrencyCache::with('country')->get()

        );
    }
}