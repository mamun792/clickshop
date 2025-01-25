<?php

namespace App\Repositories\Auth;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterRepository
{
    public function register(array $data): User
    {
        return User::create($data);
    }

    public function login(array $credentials): string
    {
       

        return $token=JWTAuth::attempt($credentials);
    }

    public function logout(): void
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }

    public function getAuthenticatedUser(): User
    {
        return JWTAuth::parseToken()->authenticate();
    }

    public function getJWTIdentifier(): int
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function getKey(): int
    {
        return $this->getKey();
    }

    public function refresh()
    {
        $newToken = JWTAuth::refresh(JWTAuth::getToken());
        return response()->json([
            'message' => 'Token refreshed',
            'token' => $newToken,
        ]);
    }

    public function respondWithToken($token)
    {
        $newToken = JWTAuth::refresh(JWTAuth::getToken());

        return response()->json([
            'message' => 'Token refreshed',
            'token' => $newToken,
        ]);
    }



}