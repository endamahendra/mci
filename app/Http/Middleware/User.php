<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class User
{
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah token ada dalam header Authorization
        $token = $request->bearerToken();

        // Jika tidak ada token dalam header Authorization, periksa apakah pengguna terotentikasi
        if (!$token && !auth()->check()) {
            abort(401, 'Unauthorized');
        }

        // Jika pengguna terotentikasi di web aplikasi, gunakan api_token
        if (auth()->check()) {
            $token = auth()->user()->api_token;
        }

        // Periksa apakah token ada
        if (!$token) {
            abort(401, 'Token not provided');
        }

        try {
            // Verifikasi token
            $user = JWTAuth::setToken($token)->toUser();
        } catch (\Exception $e) {
            // Token tidak valid
            abort(401, 'Invalid token');
        }

        // Periksa peran pengguna
        if ($user && $user->role === 'user') {
            return $next($request);
        }

        // Jika pengguna bukan user, kembalikan respons 401 (Unauthorized)
        abort(401, 'Unauthorized');
    }
}
