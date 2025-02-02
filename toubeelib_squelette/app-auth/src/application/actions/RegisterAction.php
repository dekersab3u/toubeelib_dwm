<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use toubeelib\application\actions\AbstractAction;
use toubeelib\application\providers\AuthnProviderInterface;
use toubeelib\core\dto\CredentialDTO;
use toubeelib\core\services\auth\AuthServiceBadDataException;

class RegisterAction extends AbstractAction
{

    private AuthnProviderInterface $authnProvider;

    public function __construct(AuthnProviderInterface $authnProvider){
        $this->authnProvider = $authnProvider;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();


        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $login = $data['login'] ?? null;

        try{
            $this->authnProvider->register(new CredentialDTO($email, $password), $login, 1);

        }catch(AuthServiceBadDataException $e){
            throw new HttpBadRequestException($rq, $e->getMessage());
        }

        return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);

    }
}