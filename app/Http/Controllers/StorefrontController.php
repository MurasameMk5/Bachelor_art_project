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
            'storefront' => $request->user()->storefront->with('components')->first(),
        ]);
    }
}
