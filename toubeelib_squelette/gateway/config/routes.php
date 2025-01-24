<?php

use Gateway\Application\Actions\GatewayAccesPraticiensAction;
use Psr\Container\ContainerInterface;
use GuzzleHttp\Client;

return function (\Slim\App $app) {
    $app->get('/praticiens', GatewayAccesPraticiensAction::class);
};
