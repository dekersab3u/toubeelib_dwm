<?php

namespace Gateway\Application\Actions;

use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use GuzzleHttp\ClientInterface;
use Slim\Exception\HttpBadRequestException;

class GatewayAccesPraticiensAction
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $response = $this->client->get("/praticiens");
            $body = $response->getBody()->getContents();
            $rs->getBody()->write($body);
            return $rs->withHeader('Content-Type', 'application/json')
                ->withStatus($response->getStatusCode());
        } catch (ClientException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());
        }
    }
}
