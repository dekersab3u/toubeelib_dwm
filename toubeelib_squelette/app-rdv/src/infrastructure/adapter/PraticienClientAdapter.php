<?php

namespace rdv\infrastructure\repositories;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use rdv\core\dto\PraticienDTO;
use rdv\core\dto\rdvDTO;
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

    private function getPraticiens(): array
    {
        try {
            $response = $this->remote->request('GET', 'praticiens');
            $data = json_decode($response->getBody()->getContents(), true);
            $praticiens = [];
            foreach ($data as $praticien) {
                $praticiens[] = new PraticienDTO($praticien);
            }
            return $praticiens;
        } catch (ConnectException | ServerException $e) {
            throw new RepositoryEntityNotFoundException('Praticiens not found');

        } catch (ClientException $e) {
            match($e->getCode()) {
                404 => throw new RepositoryEntityNotFoundException('Praticiens not found'),
                403 => throw new HttpForbiddenException('Forbidden'),
            };
        }

    }

    private function getPraticienRdvs(string $id): array
    {
        try {
            $response = $this->remote->request('GET', 'praticien/'.$id.'/rdvs');
            $data = json_decode($response->getBody()->getContents(), true);
            $rdvs = [];
            foreach ($data as $rdv) {
                $rdvs[] = new RdvDTO($rdv);
            }
            return $rdvs;
        } catch (ConnectException | ServerException $e) {
            throw new RepositoryEntityNotFoundException('Rdvs not found');

        } catch (ClientException $e) {
            match($e->getCode()) {
                404 => throw new RepositoryEntityNotFoundException('Rdvs not found'),
                403 => throw new HttpForbiddenException('Forbidden'),
            };
        }

    }







}
