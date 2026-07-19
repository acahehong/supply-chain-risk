<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Port;

class PortController extends Controller
{
    public function index()
    {
        return response()->json(

            Port::with('country')->get()

        );
    }
}