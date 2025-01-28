<?php

namespace gateway\application\actions;

use GuzzleHttp\Exception\ClientException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class GatewayGetPraticiensAction
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $id = $args['ID-PRA'] ?? null;
            $rdv = $rq->getUri()->getPath();
                if($id){
                    $response = $this->client->get("/praticiens/$id");
                }else {
                    $response = $this->client->get("/praticiens");
                }
        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 404) {
                throw new HttpNotFoundException($rq, "Le praticien avec l'ID $id n'existe pas.");
            }
            throw new HttpBadRequestException($rq, $e->getMessage());

        }
        return $response;
    }
}