<?php


use gateway\application\actions\GatewayGetRdvByPraticienIdAction;
use gateway\application\actions\GatewayGetPraticiensAction;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function (\Slim\App $app) {

    $app->add(\gateway\middleware\CorsMiddleware::class);
    $app->get('/', \gateway\application\actions\HomeAction::class);
    $app->get('/praticiens[/{ID-PRA}]', GatewayGetPraticiensAction::class);
    $app->get('/praticiens/{ID-PRA}/rdvs', GatewayGetRdvByPraticienIdAction::class);

    $app->options('/{routes:.+}',
        function( Request $rq,
                  Response $rs, array $args) : Response {
            return $rs;
        })->add(\gateway\middleware\CorsMiddleware::class);

    return $app;

};
