<?php

namespace toubeelib\core\services\auth;

use Firebase\JWT\JWT;

class AuthProvider
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function signin(string $email, string $password){
        $user = $this->authService->authenticate($email, $password);
        $payload = [ 'iss'=>'localhost:6080',
            'aud'=>'localhost:6080',
            'iat'=>time(),
            'exp'=>time()+3600,
            'sub' => $user->id,
            'data' => [
                'role' => $user->role,
                'user' => $user->email
            ]
        ];

        $accessToken = JWT::encode($payload, $_ENV['JWT_SECRET_KEY'], 'HS512');



    }


}