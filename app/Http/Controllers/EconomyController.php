<?php

namespace App\Http\Controllers;

use App\Models\Country;

class EconomyController extends Controller
{
    public function index()
    {
        $countries = Country::with('economicCache')->get();

        return view('economy.index', compact('countries'));
    }
}