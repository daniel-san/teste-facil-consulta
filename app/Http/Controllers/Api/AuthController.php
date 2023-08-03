<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (! auth()->attempt($request->only('email', 'password'))) {
            return response()->json(['message' => __('auth.login.failed')], 401);
        }

        /** @var \App\Models\User $user */
        $user = auth()->user();

        $token = $user->tokens()->first()->accessToken ?? $user->createToken("access_token")->accessToken;

        return response()->json([
            'message' => __('auth.login.success'),
            'token' => $token
        ]);
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        } catch (QueryException $e) {
            return response()->json(['mesage' => __('auth.register.failed')], 409);
        }

        $token = $user->createToken("access_token")->accessToken;

        return response()->json([
            'message' => __('auth.register.success'),
            'token' => $token
        ]);
    }
}

