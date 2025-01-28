<?php

namespace praticien\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use praticien\application\actions\AbstractAction;
use praticien\core\services\praticien\ServicePraticienInterface;

class GetPraticiens extends AbstractAction
{
    private ServicePraticienInterface $servicePraticien;

    public function __construct(ServicePraticienInterface $servicePraticien)
    {
        $this->servicePraticien = $servicePraticien;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try{
            $praticiensDTO = $this->servicePraticien->getPraticiens();

            foreach ($praticiensDTO as $p){
                $resultat["Praticien"][] = [
                    "id" => $p->ID,
                    "nom" => $p->nom,
                    "prenom" => $p->prenom,
                    "email" => $p->adresse,
                    "Telephone" => $p->tel
                ];
            }

            $rs->getBody()->write(json_encode($resultat));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        }catch(\Exception $e){
            $rs->getBody()->write(json_encode(['error' => 'Probleme lors de la generation' . $e->getMessage()]));

            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    }
}