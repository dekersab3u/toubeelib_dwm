<?php

namespace gateway\application\actions;

use GuzzleHttp\Exception\ClientException;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class GatewayGetRdvByPraticienIdAction
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $id = $args['ID-PRA'];
            if($id) {
                $response = $this->client->get("/praticiens/$id/rdvs");
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