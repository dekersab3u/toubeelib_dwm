<?php

namespace toubeelib\application\middlewares;

use toubeelib\application\providers\AuthnProviderInterface;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\BeforeValidException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class AuthnMiddleware
{
    private AuthnProviderInterface $authProvider;

    public function __construct(AuthnProviderInterface $authProvider)
    {
        $this->authProvider = $authProvider;
    }

    public function __invoke(Request $rq, RequestHandlerInterface $handler) : \Psr\Http\Message\ResponseInterface
    {
        try {
            try{
                $token = $rq->getHeader('Authorization')[0];
                $tokenstring = sscanf($token, 'Bearer %s')[0];
            }catch (\Exception $e){
                return (new Response())->withStatus(401);
            }

            $userDTO = $this->authProvider->getSignedInUser($tokenstring);
        } catch (ExpiredException|\UnexpectedValueException|BeforeValidException|SignatureInvalidException $e) {
            return (new Response())->withStatus(401);
        }

        $rq = $rq->withAttribute('user', $userDTO);

        return $handler->handle($rq);
    }
}