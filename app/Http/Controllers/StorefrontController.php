<?php

namespace App\Http\Controllers;

use App\Models\Storefront;
use App\Models\StorefrontArtist;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    #[Authorize('view', 'storefront')]
    public function showArtist(Request $request)
    {
        return inertia('StorefrontArtist', [
            'storefront' => $request->user()->storefront->load(['components.commission.images', 'components.commission.questions']),
            'orders' => $request->user()->ordersAsArtist()->with('commission', 'client')->get(),
        ]);
    }
    public function showClient(Request $request, Storefront $storefront)
    {
        return inertia('StorefrontClient', [
            'storefront' => $storefront->load(['components.commission.images', 'components.commission.questions']),
            'orders' => $storefront->user->ordersAsArtist()->with('commission', 'client')->get(),
        ]);
    }
}
