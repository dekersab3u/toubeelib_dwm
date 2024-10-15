<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use toubeelib\application\middlewares\CorsMiddleware;
use Dotenv\Dotenv;




$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/settings.php' );
$builder->addDefinitions(__DIR__ . '/dependencies.php');

$c=$builder->build();
$app = AppFactory::createFromContainer($c);


$app->add(new CorsMiddleware());
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware($c->get('displayErrorDetails'), false, false)
//    ->getDefaultErrorHandler()
//    ->forceContentType('application/json')
;

try {
    $envFiles = ['toubeelib.env', 'dbuser.env', 'toubeelibdb.env'];

    foreach ($envFiles as $file) {
        $dotenv = Dotenv::createImmutable(__DIR__, $file);
        $dotenv->load();
    }
} catch (Exception $e) {
    echo "Erreur lors du chargement du fichier .env : " . $e->getMessage();
}


$app = (require_once __DIR__ . '/routes.php')($app);
$routeParser = $app->getRouteCollector()->getRouteParser();


return $app;