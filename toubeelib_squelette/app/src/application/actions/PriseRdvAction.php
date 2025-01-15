<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\core\services\rdv\RdvServiceInterface;
use Respect\Validation\Validator;

class PriseRdvAction extends AbstractAction
{
    private RdvServiceInterface $rdvInt;

    public function __construct(RdvServiceInterface $rdvInt)
    {
        $this->rdvInt = $rdvInt;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $data = json_decode($rq->getBody()->getContents(), true);

            $validator = Validator::arrayType()
                ->key('idPra', Validator::uuid()->notEmpty())
                ->key('idCli', Validator::uuid()->notEmpty())
                ->key('specialite', Validator::stringType()->notEmpty())
                ->key('dateRdv', Validator::date('Y-m-d\TH:i:s'));




            if (!$validator->validate($data)) {
                throw new \InvalidArgumentException("Données invalides pour la création du rendez-vous.");
            }
            $dateRdvStr = $data['dateRdv'] ?? null;
            $idPra = $data['idPra'];
            $idCli = $data['idCli'];
            $specialite = $data['specialite'];
            $dateRdv = new \DateTimeImmutable($dateRdvStr);


            $rdv = $this->rdvInt->creerRDV($idCli, $idPra, $specialite, $dateRdv);

            $rs->getBody()->write(json_encode([
                'message' => 'Rendez-vous créé avec succès',
                'rdv' => [
                    'id' => $rdv->ID,
                    'id_patient' => $rdv->ID_Patient,
                    'id_praticien' => $rdv->ID_Praticien,
                    'specialite' => $rdv->specialite,
                    'date' => $rdv->dateRdv->format('Y-m-d\TH:i:s'),
                    'status' => $rdv->status,
                ],
            ]));

            return $rs->withHeader('Content-Type', 'application/json')->withStatus(201);

        } catch (\InvalidArgumentException $e) {
            $rs->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(400);
        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
