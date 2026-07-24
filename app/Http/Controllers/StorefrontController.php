<?php

namespace App\Http\Controllers;

use App\Models\Storefront;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    #[Authorize('view', 'storefront')]
    public function show(Request $request)
    {
        return inertia('Storefront', [
            'storefront' => $request->user()->storefront->load('components.commission.images'),
            'orders' => $request->user()->ordersAsArtist()->with('commission', 'client')->get(),
        ]);
    }
}
