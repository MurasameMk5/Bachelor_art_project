<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Routing\Attributes\Controllers\Authorize;
use Inertia\Inertia;

class OrderController extends Controller
{
    
    #[Authorize('viewAny', Order::class)]
    public function index()
    {
        $orders = Order::with(['artist', 'client', 'commission'])->get();
        
        return Inertia::render('Dashboard', [
            'orders' => $orders
            ]);
    }
            
    #[Authorize('view', 'order')]
    public function show(Order $order)
    {

        return Inertia::render('Order', [
            'order' => $order
        ]);
    }
}
