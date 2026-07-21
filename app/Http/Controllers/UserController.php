<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function show(Request $request)
    {
        return Inertia::render('Profile', [
            'user' => $request->user(),
        ]);
    }
}
