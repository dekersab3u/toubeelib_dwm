<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):\Slim\App {

    $app->get('/', \toubeelib\application\actions\HomeAction::class);
    $app->get('/rdvs/{ID-RDV}', \toubeelib\application\actions\AccesRdvAction::class);
    $app->patch('/rdvs/{ID-RDV}', \toubeelib\application\actions\ModifRdvAction::class);
    $app->delete('/rdvs/{ID-RDV}', \toubeelib\application\actions\AnnulerRdvAction::class);
    $app->patch('/praticiens/{ID-PRA}', \toubeelib\application\actions\PracticienDisponibiliteAction::class);

    $app->options('/{routes:.+}',
        function( Request $rq,
                  Response $rs, array $args) : Response {
            return $rs;
        })->add(new \toubeelib\application\middlewares\CorsMiddleware());

    return $app;
};