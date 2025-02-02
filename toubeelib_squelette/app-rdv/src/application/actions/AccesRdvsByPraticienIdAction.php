<?php

namespace rdv\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use rdv\core\services\rdv\RdvServiceInterface;
use Respect\Validation\Validator;

class AccesRdvsByPraticienIdAction extends AbstractAction
{
    private RdvServiceInterface $rdvService;

    public function __construct(RdvServiceInterface $rdvService)
    {
        $this->rdvService = $rdvService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {

            $idPraticien = $args['ID-PRA'] ?? null;
            
            $rdvs = $this->rdvService->consulterRdvsPraticien($idPraticien);


            $responseBody = [
                'message' => 'Liste des rendez-vous récupérée avec succès',
                'rdvs' => array_map(fn($rdvDTO) => [
                    'id' => $rdvDTO->ID,
                    'id_patient' => $rdvDTO->ID_Patient,
                    'id_praticien' => $rdvDTO->ID_Praticien,
                    'specialite' => $rdvDTO->specialite,
                    'date' => $rdvDTO->dateRdv->format('Y-m-d\TH:i:s'),
                    'status' => $rdvDTO->status,
                ], $rdvs),
            ];

            $rs->getBody()->write(json_encode($responseBody));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);

        } catch (\InvalidArgumentException $e) {
            $rs->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['error' => 'Une erreur est survenue : ' . $e->getMessage()]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
