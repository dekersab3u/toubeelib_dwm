<?php

use toubeelib\core\domain\entities\praticien\Praticien;
use toubeelib\core\domain\entities\praticien\Specialite;
use toubeelib\core\services\rdv\ServiceRdvInvalidDataException;

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

/*
try{

    $test = $service->modifierRDV('r1', null, "dermatologue");
    echo $test->status . "\n";
} catch (\toubeelib\core\services\rdv\ServiceRdvInvalidDataException $e){
    echo 'exception : ' . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
}
*/



$dateDebut = new \DateTime('2024-09-02');
$dateFin = new \DateTime('2024-09-02');

$disponibilites = $service->listeDisponibilitesPraticien('p1', $dateDebut, $dateFin);
foreach ($disponibilites as $dispo) {
    echo $dispo->format('Y-m-d H:i') . PHP_EOL;
}

try {
    $praticienRepo = new \toubeelib\infrastructure\repositories\ArrayPraticienRepository();
    $specialites = $praticienRepo->getSpecialitesByPraticienId('p1');

    foreach ($specialites as $specialite) {
        echo "Spécialité : " . $specialite->label . "\n";
    }
} catch (RepositoryEntityNotFoundException $e) {
    echo "Erreur : " . $e->getMessage();
}

try {
    $rdvDTO = $service->creerRDV('patient1', 'p1', 'Dentiste', new \DateTimeImmutable('2024-09-21 12:00'));

    echo $rdvDTO->specialite . PHP_EOL;

   } catch (ServiceRdvInvalidDataException $e) {
    echo "Erreur lors de la création du rendez-vous : " . $e->getMessage();
}














