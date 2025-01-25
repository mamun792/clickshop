<?php

namespace App\Services\Api\Auth;

use App\Models\User;
use App\Repositories\Auth\RegisterRepository;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Auth\AuthenticationException;

class RegisterService
{
    protected $registerRepository;

    public function __construct(RegisterRepository $registerRepository)
    {
        $this->registerRepository = $registerRepository;
    }

    public function register(array $data): User
    {
        return $this->registerRepository->register($data);
    }

    public function login(array $credentials): string
    {
        
        $token = JWTAuth::attempt($credentials);

      
        if (!$token) {
            throw new AuthenticationException('Invalid email or password');
        }

        return $token;
    }


    public function logout(): void
    {
        $this->registerRepository->logout();
    }

    public function getAuthenticatedUser(): User
    {
        if (!JWTAuth::parseToken()->authenticate()) {
            throw new AuthenticationException('Unauthenticated user');
        }

        return $this->registerRepository->getAuthenticatedUser();
    }

    public function refresh()
    {
        return $this->registerRepository->refresh();
    }

    protected function respondWithToken($token)
    {
        return $this->registerRepository->respondWithToken($token);
    }
}
