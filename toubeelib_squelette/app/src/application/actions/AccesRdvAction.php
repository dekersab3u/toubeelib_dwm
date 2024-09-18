<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\application\actions\AbstractAction;
use toubeelib\core\repositoryInterfaces\RdvRepositoryInterface;
use toubeelib\core\services\rdv\RdvServiceInterface;

class AccesRdvAction extends AbstractAction
{
    private RdvServiceInterface $rdvInt;

    public function __construct(RdvServiceInterface $rdvInt)
    {
        $this->rdvInt = $rdvInt;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $rdv_id = $args['ID-RDV'];

        try{
            $rdv = $this->rdvInt->consulterRDV($rdv_id);
            $resultat = ["rendez-vous" => [
                "id" => $rdv->ID,
                "id_patient" => $rdv->ID_Patient,
                "id_praticien" => $rdv->ID_Praticien,
                "spécialité_praticien" => $rdv->specialite,
                "horaire" => $rdv->dateRdv,
                "status" => $rdv->status
            ],
                "links" => [
                    "self" => [
                        "href" => "/rdvs/" . $rdv->ID
                    ]
                ]
            ];


            $rs->getBody()->write(json_encode($resultat));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        }catch (\Exception $e){
            $rs->getBody()->write(json_encode(['error' => 'Rendez-vous non trouvé']));

            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404);
        }
    }
}