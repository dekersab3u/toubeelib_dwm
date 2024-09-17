<?php

require_once __DIR__ . '/../vendor/autoload.php';

$service = new \toubeelib\core\services\rdv\ServiceRDV(new \toubeelib\infrastructure\repositories\ArrayRdvRepository(), new \toubeelib\infrastructure\repositories\ArrayPraticienRepository()
);



try{
    $test = $service->consulterRDV('r1');
    echo $test->ID . "\n";
}catch (\toubeelib\core\services\rdv\ServiceRdvInvalidDataException $e){
    echo 'exception : ' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
}

try{
    $test = $service->consulterRDV('r1');
    $service->annulerRDV($test->ID);
    $test2 = $service->consulterRDV('r1');
    echo $test2->status . "\n";
}catch (\toubeelib\core\services\rdv\ServiceRdvInvalidDataException $e){
    echo 'exception : ' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
}



