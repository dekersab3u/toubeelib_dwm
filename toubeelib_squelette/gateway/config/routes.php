<?php


use gateway\application\actions\GatewayGetPraticiensAction;
use gateway\application\actions\GatewayGetRdvByPraticienIdAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (\Slim\App $app) {

    $app->add(gateway\application\middleware\CorsMiddleware::class);
    $app->get('/', \gateway\application\actions\HomeAction::class);
    $app->get('/praticiens[/{ID-PRA}]', GatewayGetPraticiensAction::class);
    $app->get('/praticiens/{ID-PRA}/rdvs', GatewayGetRdvByPraticienIdAction::class);
    $app->post('/signin', \gateway\application\actions\GatewaySignInAction::class);
    $app->post('/register', \gateway\application\actions\GatewayRegisterAction::class);

    $app->options('/{routes:.+}',
        function( Request $rq,
                  Response $rs, array $args) : Response {
            return $rs;
        })->add(gateway\application\middleware\CorsMiddleware::class);

    return $app;

};
