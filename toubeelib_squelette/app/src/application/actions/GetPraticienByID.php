<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\application\actions\AbstractAction;
use toubeelib\core\services\praticien\ServicePraticienInterface;

class GetPraticienByID extends AbstractAction
{

    private ServicePraticienInterface $servicePraticien;

    public function __construct(ServicePraticienInterface $praticien){
        $this->servicePraticien = $praticien;
    }


    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $prat_id = $args['ID-PRA'];

        try{

            $prat = $this->servicePraticien->getPraticienById($prat_id);

            $resultat = ["Praticien" => [
                "id" => $prat->ID,
                "nom" => $prat->nom,
                "prenom" => $prat->prenom,
                "email" => $prat->adresse,
                "Telephone" => $prat->tel
            ]];

            $rs->getBody()->write(json_encode($resultat));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        }catch(\Exception $e){
            $rs->getBody()->write(json_encode(['error' => 'Praticien non trouve : ' . $prat_id]));

            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    }
}
