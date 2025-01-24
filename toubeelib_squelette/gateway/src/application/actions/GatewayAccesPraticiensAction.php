<?php

namespace gateway\application\actions;

use GuzzleHttp\Exception\ClientException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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
        } catch (ClientException $e) {
            throw new HttpBadRequestException($rq, $e->getMessage());

        }
        return $response;
    }
}
