<?php

use gateway\application\actions\GatewayAccesPraticiensAction;

return function (\Slim\App $app) {
    $app->get('/', \gateway\application\actions\HomeAction::class);
    $app->get('/praticiens', GatewayAccesPraticiensAction::class);

    return $app;

};
