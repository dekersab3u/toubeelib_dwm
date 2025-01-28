<?php

namespace rdv\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use rdv\core\services\rdv\RdvServiceInterface;
use Respect\Validation\Validator;

class ModifRdvAction extends AbstractAction
{

    private RdvServiceInterface $rdvInt;

    public function __construct(RdvServiceInterface $rdvInt)
    {
        $this->rdvInt = $rdvInt;
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $rdv_id = $args['ID-RDV'];
        $body = $rq->getParsedBody();
        $specialite = null;
        $idpatient = null;

        $validator = Validator::key('specialite', Validator::optional(Validator::stringType()))
            ->key('idpatient', Validator::optional(Validator::stringType()));

        try{
            assert($validator);
            $rdv = $this->rdvInt->consulterRDV($rdv_id);

            try{
                if(isset($body['specialite'])){
                    $specialite = $body['specialite'];
                }
                if(isset($body['idpatient'])){
                    $idpatient = $body['idpatient'];
                }


            }catch (\Exception $e){
                $rs->getBody()->write(json_encode(['error' => 'erreur sur les parametres données']));

                return $rs
                    ->withHeader('Content-Type', 'application/json')
                    ->withStatus(404);
            }


            $modifrdv = $this->rdvInt->modifierRDV($rdv->ID,$idpatient, $specialite);

            $resultat= ["rendez-vous" => [
                "id" => $modifrdv->ID,
                "id_patient" => $modifrdv->ID_Patient,
                "id_praticien" => $modifrdv->ID_Praticien,
                "spécialité_praticien" => $modifrdv->specialite,
                "horaire" => $modifrdv->dateRdv,
                "status" => $modifrdv->status
            ],
                "links" => [
                    "self" => [
                        "href" => "/rdvs/" . $modifrdv->ID
                    ]
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
            $rs->getBody()->write((json_encode(['error' => 'Erreur interne du serveur'])));
            return $rs
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500);
        }
    }
}