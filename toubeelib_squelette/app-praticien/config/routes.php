<?php
declare(strict_types=1);

use praticien\application\actions\GetPraticienByID;
use praticien\application\actions\GetPraticiens;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function( \Slim\App $app):\Slim\App {

    $app->get('/praticiens', GetPraticiens::class);
    $app->get('/praticiens/{ID-PRA}', GetPraticienByID::class);

    return $app;
};