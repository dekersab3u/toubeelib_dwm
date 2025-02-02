<?php

namespace toubeelib\application\actions;

use toubeelib\application\providers\JWTAuthnProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpUnauthorizedException;

class ValiderTokenAction
{
    private $authnProvider;

    public function __construct(JWTAuthnProvider $authnProvider)
    {
        $this->authnProvider = $authnProvider;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $authHeader = $request->getHeaderLine('Authorization');
            if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                throw new HttpUnauthorizedException($request, 'Token JWT manquant ou mal formaté.');
            }

            $token = $matches[1];
            $claims = $this->authnProvider->validateToken($token);

            $response->getBody()->write(json_encode([
                'message' => 'Token valide.',
                'claims' => $claims,
            ]));

            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => 'Unauthorized',
                'message' => $e->getMessage(),
            ]));

            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
    }
}
