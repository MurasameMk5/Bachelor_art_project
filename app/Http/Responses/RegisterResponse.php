<?php
namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse;

class RegisterResponse implements LoginResponse
{
    public function toResponse($request)
    {
        $user = $request->user();

        $redirectTo = match ($user->role) {
            'artist' => '/dashboard',
            'client' => '/profile',
            default => '/',
        };

        return redirect($redirectTo);
    }
}
