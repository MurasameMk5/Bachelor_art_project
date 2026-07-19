<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show($id)
    {
        return Inertia::render('Order', [
            'id' => $id
        ]);
    }
}
