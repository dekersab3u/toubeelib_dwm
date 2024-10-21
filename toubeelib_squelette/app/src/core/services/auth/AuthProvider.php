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

        try{
            $user = $this->authService->authenticate($email, $password);
            $payload = [ 'iss'=>'localhost:6080',
                'aud'=>'localhost:6080',
                'iat'=>time(),
                'exp'=>time()+3600,
                'sub' => $user['uuid'],
                'data' => [
                    'role' => $user['role'],
                    'user' => $user['email']
                ]
            ];

            $accessToken = JWT::encode($payload, $_ENV['JWT_SECRET_KEY'], 'HS512');

            return [
                'access_token' => $accessToken,
                'expires_in' => 3600,
                'user' => $user['email'],
                'role' => $user['role']
            ];

        }catch(\Exception $e){
            throw new \Exception('pas bon');
        }




    }


}