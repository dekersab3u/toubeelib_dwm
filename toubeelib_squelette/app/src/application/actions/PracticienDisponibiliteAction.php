<?php

namespace toubeelib\application\actions;

use _PHPStan_9815bbba4\Nette\Utils\DateTime;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\application\actions\AbstractAction;
use toubeelib\core\services\praticien\ServicePraticienInterface;
use toubeelib\core\services\rdv\RdvServiceInterface;
use Respect\Validation\Validator;

class PracticienDisponibiliteAction extends AbstractAction
{

    private RdvServiceInterface $rdvInt;
    private ServicePraticienInterface $praInt;

    public function __construct(RdvServiceInterface $rdvInt, ServicePraticienInterface $praInt)
    {
        $this->rdvInt = $rdvInt;
        $this->praInt= $praInt;
    }


    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $pra_id = $args['ID-PRA'];
        $body = $rq->getParsedBody();
        $dateD = null;
        $dateF = null;

        $validator = Validator::key($body['dateD'], Validator::dateTime('Y-m-d H:i'))
            ->key($body['dateF'], Validator::dateTime('Y-m-d H:i'));
    try{
        assert($validator);
        if(isset($body['dateD'])){
            $dateD =DateTime::createFromFormat('Y-m-d H:i', $body['dateD']);
        }
        if(isset($body['dateF'])){
            $dateF = DateTime::createFromFormat('Y-m-d H:i', $body['dateF']);
        }
        $praticien = $this->praInt->getPraticienById($pra_id);
        $tab = $this->rdvInt->listeDisponibilitesPraticien($praticien->ID, $dateD, $dateF );

        $resultat = ["praticien" => [
            "nom" => $praticien->nom,
            "prenom" => $praticien->prenom,
            "Disponibilites" => $tab
        ]
        ];

        $rs->getBody()->write(json_encode($resultat));
        return $rs
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }catch(\InvalidArgumentException $e){
        $rs->getBody()->write(json_encode(['error' => 'Rendez-vous non trouvé']));

        return $rs
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(404);
    }catch (\Exception $e){
        $rs->getBody()->write(json_encode(['error' => 'Erreur interne']));

        return $rs
            ->withHeader('Content-Type', 'application/json');
    }
    }
}