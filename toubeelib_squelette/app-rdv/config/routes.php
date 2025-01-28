<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):\Slim\App {

    $app->get('/rdvs', \rdv\application\actions\AccesRdvsAction::class);
    $app->post('/rdvs', \rdv\application\actions\PriseRdvAction::class);
    $app->get('/rdvs/{ID-RDV}', \rdv\application\actions\AccesRdvByIdAction::class);
    $app->patch('/rdvs/{ID-RDV}', \rdv\application\actions\ModifRdvAction::class);
    $app->delete('/rdvs/{ID-RDV}', \rdv\application\actions\AnnulerRdvAction::class);
    $app->patch('/praticiens/{ID-PRA}', \rdv\application\actions\PracticienDisponibiliteAction::class);
    $app->get('/praticiens/{ID-PRA}/rdvs', \rdv\application\actions\AccesRdvsByPraticienIdAction::class);
    $app->get('/patients', \rdv\application\actions\GetPatientsAction::class);


    return $app;
};