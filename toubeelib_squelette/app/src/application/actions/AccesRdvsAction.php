<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\core\services\rdv\RdvServiceInterface;

class AccesRdvsAction extends AbstractAction
{
    private RdvServiceInterface $rdvInt;

    public function __construct(RdvServiceInterface $rdvInt)
    {
        $this->rdvInt = $rdvInt;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {

            $listeRdv = $this->rdvInt->consulterListeRDVs();

            $resultat = array_map(function ($rdv) {
                return [
                    "id" => $rdv->ID,
                    "id_patient" => $rdv->ID_Patient,
                    "id_praticien" => $rdv->ID_Praticien,
                    "spécialité_praticien" => $rdv->specialite,
                    "horaire" => $rdv->dateRdv,
                    "status" => $rdv->status,
                    "links" => [
                        "self" => [
                            "href" => "/rdvs/" . $rdv->ID,
                        ],
                    ],
                ];
            }, $listeRdv);

            $rs->getBody()->write(json_encode(["rendez-vous" => $resultat]));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['error' => 'Impossible de récupérer les rendez-vous.']));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}
