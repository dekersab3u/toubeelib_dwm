<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\application\actions\AbstractAction;
use toubeelib\core\services\auth\AuthProvider;

class SignInAction extends AbstractAction
{

    private AuthProvider $authProvider;

    public function __construct(AuthProvider $a){
        $this->authProvider = $a;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        try{
            $body = $rq->getParsedBody();
            $email = $body['email'] ?? null;
            $password = $body['password'] ?? null;

            if(!$email || !$password){
                $rs->getBody()->write(json_encode(['error' => 'email ou mdp non present']));
                return $rs->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
        }catch(\Exception $e){
            $rs->getBody()->write(json_encode(['error' => 'test']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(401);
        }




        try{

            $token = $this->authProvider->signin($email, $password);

            $rs->getBody()->write(json_encode([
                'access_token' => $token['access_token'],
                'expires_in' => $token['expires_in'],
                'user' => $token['user'],
                'role' => $token['role']
            ]));

            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);

        }catch(\Exception $e){
            $rs->getBody()->write(json_encode(['error' => 'Invalid credentials']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(401);
        }


    }
}