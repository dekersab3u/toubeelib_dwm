<?php

require_once __DIR__ . '/../vendor/autoload.php';

$service = new \toubeelib\core\services\rdv\ServiceRDV(new \toubeelib\infrastructure\repositories\ArrayRdvRepository(), new \toubeelib\infrastructure\repositories\ArrayPraticienRepository()
);



try{
    $test = $service->consulterRDV('r1');
    print($test->ID_Patient);
}catch (\toubeelib\core\services\rdv\ServiceRdvInvalidDataException $e){
    echo 'exception : ' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
}





