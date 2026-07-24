<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Inertia\Inertia;
use App\Models\Commission;

class CommissionController extends Controller
{
    public function show(Request $request, Commission $commission)
    {

        return Inertia::render('OrderForm', [
            'commission' => $commission->load(['artist', 'images']),
            'user' => $request->user(),
        ]);
    }
}
