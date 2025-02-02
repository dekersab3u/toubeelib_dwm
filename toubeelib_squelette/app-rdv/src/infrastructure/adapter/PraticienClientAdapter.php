<?php

namespace rdv\infrastructure\repositories;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use rdv\core\dto\PraticienDTO;
use rdv\core\repositoryInterfaces\RepositoryEntityNotFoundException;
use Slim\Exception\HttpForbiddenException;
use function DI\string;

class  PraticienClientAdapter {
    private ClientInterface $remote;

    public function __construct(ClientInterface $remote) {
        $this->remote = $remote;
    }

    private function getPraticienById(string $id): PraticienDTO
    {
        try {
            $response = $this->remote->request('GET', 'praticien/'.$id);
            $data = json_decode($response->getBody()->getContents(), true);
            return new PraticienDTO($data);
        } catch (ConnectException | ServerException $e) {
            throw new RepositoryEntityNotFoundException('Praticien not found');

        } catch (ClientException $e) {
            match($e->getCode()) {
                404 => throw new RepositoryEntityNotFoundException('Praticien not found'),
                403 => throw new HttpForbiddenException('Forbidden'),
            };
        }

    }

}
