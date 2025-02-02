<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use toubeelib\application\actions\AbstractAction;
use toubeelib\application\providers\AuthnProviderInterface;
use toubeelib\core\dto\CredentialDTO;
use toubeelib\core\services\auth\AuthProvider;
use toubeelib\core\services\auth\AuthServiceBadDataException;

class SignInAction extends AbstractAction
{

    private AuthnProviderInterface $authProvider;

    public function __construct(AuthnProviderInterface $a){
        $this->authProvider = $a;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {

        $data = $rq->getParsedBody();
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;


        try {
            $user = $this->authProvider->signin(new CredentialDTO($email, $password));
            $token = $user->getToken();
        }catch(AuthServiceBadDataException $e){
            throw new HttpBadRequestException($rq, $e->getMessage());
        }

        $rs->getBody()->write(json_encode([
            'token' => $token,
            'role' => $user->getRole()
        ]));

        return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);


    }
}