<?php

namespace gateway\application\actions;

use GuzzleHttp\Exception\ClientException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;

class GatewayRegisterAction
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        try {
            $body = $request->getParsedBody();

            if (empty($body['email']) || empty($body['password'])) {
                throw new HttpBadRequestException($request, 'Email et mot de passe sont requis.');
            }

            $backendResponse = $this->client->post('/register', [
                'json' => $body
            ]);

            $response->getBody()->write($backendResponse->getBody()->getContents());
            return $response->withStatus($backendResponse->getStatusCode())
                ->withHeader('Content-Type', 'application/json');

        } catch (ClientException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            return $response->withStatus($statusCode)
                ->withHeader('Content-Type', 'application/json');
        }
    }
}
