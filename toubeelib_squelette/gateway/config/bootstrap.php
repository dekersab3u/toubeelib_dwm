<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/settings.php' );
$builder->addDefinitions(__DIR__ . '/dependencies.php');


$c = $builder->build();

$app = AppFactory::createFromContainer($c);

$app = (require_once __DIR__ . '/routes.php')($app);


return $app;