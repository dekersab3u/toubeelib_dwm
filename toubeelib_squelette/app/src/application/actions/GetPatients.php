<?php

namespace toubeelib\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\core\services\patient\ServicePatientInterface;
use toubeelib\core\services\rdv\RdvServiceInterface;

class GetPatients extends AbstractAction
{

    private ServicePatientInterface $servicePatient;

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $this->servicePatient = $servicePatient;


    }

}
