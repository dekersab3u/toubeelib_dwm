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

        $data = $rq->getParsedBody();
        $idPra = $data['idPra'] ?? null;
        $idCli = $data['idCli'] ?? null;
        $specialite = $data['specialite'] ?? null;
        $dateRdv = $data['dateRdv'] ?? null;
        try{
            $this->rdvInt->creerRDV($idPra, $idCli, $specialite, $dateRdv);
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);
        }catch(\Exception $e){
            $rs->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(404);
        }










    }
}