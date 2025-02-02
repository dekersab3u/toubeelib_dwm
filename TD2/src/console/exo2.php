<?php
$entityManager = require_once __DIR__ . '/ORM_bootstrap.php';

use iutnc\doctrine\src\core\domain\entities\Praticien;
use iutnc\doctrine\src\core\domain\entities\Specialite;
use iutnc\doctrine\src\core\domain\entities\Type_Groupement;



$repositories = [
    'praticien' => $entityManager->getRepository(Praticien::class),
    'specialite' => $entityManager->getRepository(Specialite::class),
    'typeGroupement' => $entityManager->getRepository(Type_Groupement::class),
];

function afficherQuestion($numero, $description, $resultats) : void  {
    $separateur = str_repeat("-", 78);
    print "\n##############################################################################\n";
    print "Question $numero : $description \n";
    print "$separateur\n";
    foreach ($resultats as $resultat) {
        print "$resultat\n";
    }
    print "\n";
}

// Question 1
$praticien1 = $repositories['praticien']->findOneBy(["email" => "Gabrielle.Klein@live.com"]);
$description1 = "Afficher le praticien dont le mail est Gabrielle.Klein@live.com.";
$resultats1 = [
    $praticien1->getPrenom() . ' ' . $praticien1->getNom() . ' -> ' . $praticien1->getEmail()
];
afficherQuestion(1, $description1, $resultats1);

// Question 2
$praticien2 = $repositories['praticien']->findOneBy(["nom" => "Goncalves", "ville" => "Paris"]);
$description2 = "Afficher le praticien de nom Goncalves à Paris.";
$resultats2 = [
    $praticien2->getPrenom() . ' ' . $praticien2->getNom() . ' de ' . $praticien2->getVille() . ' -> ' . $praticien2->getEmail()
];
afficherQuestion(2, $description2, $resultats2);

// Question 3
$specialite = $repositories['specialite']->findOneBy(["libelle" => "pédiatrie"]);
$description3 = "Afficher la spécialité de libellé 'pédiatrie' ainsi que les praticiens associés.";
$resultats3 = [
    "Spécialité : " . $specialite->getLibelle() . ' -> ' . $specialite->getDescription(),
    "Praticiens associés :"
];
foreach ($specialite->getPraticiens() as $praticien) {
    $resultats3[] = " - " . $praticien->getPrenom() . ' ' . $praticien->getNom();
}
afficherQuestion(3, $description3, $resultats3);

// Question 4
$typeGroupements = $repositories['typeGroupement']->findBy([]);
$description4 = "Afficher les types de groupements contenants 'santé' dans leur description.";
$resultats4 = ["Types de groupements contenant 'santé' dans leur description :"];
foreach ($typeGroupements as $type) {
    if (str_contains($type->getDescription(), "santé")) {
        $resultats4[] = "- " . $type->getLibelle() . " -> " . $type->getDescription();
    }
}
afficherQuestion(4, $description4, $resultats4);

// Question 5
$specialite2 = $repositories['specialite']->findOneBy(["libelle" => "ophtalmologie"]);
$description5 = "Afficher les praticiens de la spécialité 'ophtalmologie' exerçants à Paris.";
$resultats5 = ["Praticiens de la spécialité 'ophtalmologie' exerçants à Paris :"];
foreach ($specialite2->getPraticiens() as $praticien) {
    if (str_contains($praticien->getVille(), "Paris")) {
        $resultats5[] = "- " . $praticien->getPrenom() . ' ' . $praticien->getNom();
    }
}
afficherQuestion(5, $description5, $resultats5);

