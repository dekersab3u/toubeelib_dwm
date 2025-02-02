<?php

namespace rdv\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use rdv\core\services\patient\ServicePatient;
use rdv\core\services\patient\ServicePatientInterface;

class GetPatientsAction extends AbstractAction
{

    private ServicePatientInterface $servicePatient;

    public function __construct(ServicePatientInterface $servicePatient)
    {
        $this->servicePatient = $servicePatient;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $patientsDTO = $this->servicePatient->getPatients();

            foreach ($patientsDTO as $p) {
                $resultat["Patient"][] = [
                    "id" => $p->ID,
                    "nom" => $p->nom,
                    "prenom" => $p->prenom,
                    "email" => $p->email
                    //"role" => $p->role,
                    //"dateNais" => $p->dateNais
                ];
            }

            $rs->getBody()->write(json_encode($resultat));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }  catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['error' => 'Impossible de récupérer la liste des clients' . $e->getMessage()]));

            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }

    }

}
