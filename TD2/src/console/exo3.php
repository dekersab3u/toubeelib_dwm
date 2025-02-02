<?php
// bootstrap.php - Configuration de Doctrine
$entityManager = require_once __DIR__ . '/ORM_bootstrap.php';

use iutnc\doctrine\src\core\domain\entities\Personnel;
use iutnc\doctrine\src\core\domain\entities\Praticien;
use iutnc\doctrine\src\core\domain\entities\Specialite;



function displayQuestionHeader($questionNumber, $questionText) :void  {
    print "##############################################################################" . PHP_EOL;
    print "Question $questionNumber : $questionText \n";
    print "------------------------------------------------------------------------------" . PHP_EOL;
}

// Récupération des repositories
$praticienRepository = $entityManager->getRepository(Praticien::class);
$specialiteRepository = $entityManager->getRepository(Specialite::class);
$personnelRepository = $entityManager->getRepository(Personnel::class);

// Question n°1
displayQuestionHeader(1, "liste des praticiens d'une spécialité donnée, en incluant leur groupement d’appartenance");
$specialite = 'Dentiste';
$praticiens = $praticienRepository->getPraticienBySpecialite($specialite);
print "Les praticiens de la spécialité $specialite sont : \n";
foreach ($praticiens as $praticien) {
    print "- " . $praticien->getNom() . ' ' . $praticien->getPrenom() . ' du groupement -> ' . $praticien->getGroupement()->getNom() . PHP_EOL;
}

// Question n°2
print PHP_EOL;
displayQuestionHeader(2, "liste des spécialités contenant un mot clé dans le libellé ou la description");
$mot = 'Médecine';
$specialites = $specialiteRepository->getSpecialtitesByKeyword($mot);
print "Les spécialités contenant le mot clé $mot dans le libelle ou la description sont : \n";
foreach ($specialites as $specialite) {
    print "- " . $specialite->getLibelle(). PHP_EOL;
}

// Question n°3
print PHP_EOL;
displayQuestionHeader(3, "liste des praticiens d’une spécialité donnée exerçant dans une ville donnée");
$ville2 = 'Diaz-sur-Boulanger';
$specialite2 = 'Dentiste';
$praticiens = $praticienRepository->getPraticienBySpeAndCity($specialite2, $ville2);
print "Les praticiens de la spécialité $specialite2 exerçant à $ville2 sont : \n";
foreach ($praticiens as $praticien) {
    print "- " . $praticien->getNom() . ' ' . $praticien->getPrenom() . PHP_EOL;
}

// Question n°4
print PHP_EOL;
displayQuestionHeader(4, "Liste des personnels travaillant dans une ville donnée");
$ville = 'Moreno';
$personnels = $personnelRepository->getPersonnelByVille($ville);
print "Les personnels travaillant à $ville sont : \n";
foreach ($personnels as $personnel) {
    print "- " . $personnel->getNom() . ' ' . $personnel->getPrenom() . PHP_EOL;
}
print PHP_EOL;
