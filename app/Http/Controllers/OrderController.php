<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Inertia\Inertia;

class OrderController extends Controller
{
    #[Authorize('view', 'order')]
    public function show(Request $request, Order $order)
    {

        return Inertia::render('Order', [
            'order' => $order
        ]);
    }
}
