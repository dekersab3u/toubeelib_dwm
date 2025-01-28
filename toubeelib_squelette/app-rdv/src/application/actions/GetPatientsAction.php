<?php

namespace rdv\application\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use toubeelib\core\services\rdv\RdvServiceInterface;

class GetPatientsAction extends AbstractAction
{

    private PatientsServiceInterface

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        // TODO: Implement __invoke() method.

    }

}
