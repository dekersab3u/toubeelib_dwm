<?php

$entityManager = require_once __DIR__ . '/ORM_bootstrap.php';

use iutnc\doctrine\src\core\domain\entities\Praticien;
use iutnc\doctrine\src\core\domain\entities\Specialite;
use iutnc\doctrine\src\core\domain\entities\Type_Groupement;
use iutnc\doctrine\src\core\domain\entities\Groupement;

function displayQuestionHeader($questionNumber, $questionText) : void {
    print "##############################################################################" . PHP_EOL;
    print "Question $questionNumber : $questionText \n";
    print "------------------------------------------------------------------------------" . PHP_EOL;
}

// Récupération des repositories
$specialiteRepository = $entityManager->getRepository(Specialite::class);
$typeGroupementRepository = $entityManager->getRepository(Type_Groupement::class);
$praticienRepository = $entityManager->getRepository(Praticien::class);
$groupementRepository = $entityManager->getRepository(Groupement::class);

// Question 1
displayQuestionHeader(1, "Afficher la spécialité d'identifiant 1.");
$specialite = $specialiteRepository->find(1);
print " | Id : " . $specialite->getId() . PHP_EOL .
    " | Specialite : " . $specialite->getLibelle() . PHP_EOL .
    " | Description : " . $specialite->getDescription() . PHP_EOL;

// Question 2
print PHP_EOL;
displayQuestionHeader(2, "Afficher le type de groupement n°1.");
$typeGroupement = $typeGroupementRepository->find(1);
print " | Id : " . $typeGroupement->getId() . PHP_EOL .
    " | TypeGroupement : " . $typeGroupement->getLibelle() . PHP_EOL .
    " | Description : " . $typeGroupement->getDescription() . PHP_EOL;

// Question 3
print PHP_EOL;
displayQuestionHeader(3, "Afficher le praticien dont l’id est : 8ae1400f-d46d-3b50-b356-269f776be532.");
$praticien = $praticienRepository->findOneBy(['id' => "8ae1400f-d46d-3b50-b356-269f776be532"]);
print " | Id : " . $praticien->getId() . PHP_EOL .
    " | Nom : " . $praticien->getNom() . PHP_EOL .
    " | Prenom : " . $praticien->getPrenom() . PHP_EOL .
    " | Ville : " . $praticien->getVille() . PHP_EOL .
    " | Email : " . $praticien->getEmail() . PHP_EOL .
    " | Telephone : " . $praticien->getTelephone() . PHP_EOL;

// Question 4
print PHP_EOL;
displayQuestionHeader(4, "Compléter en affichant sa spécialité et son groupement de rattachement");
print " | Specialité : " . $praticien->getSpecialite()->getLibelle() . PHP_EOL .
    " | Groupement : " . $praticien->getGroupement()->getNom() . PHP_EOL;

// Question 5
print PHP_EOL;
displayQuestionHeader(5, "Créer un praticien, spécialité pédiatrie, et le sauvegarder dans la base");
$newPraticien = new Praticien();
$newPraticien->setId("7202b2f8-06be-42da-abf7-c40ac842b827");
$newPraticien->setNom("Jeandidier");
$newPraticien->setPrenom("Clément");
$newPraticien->setVille("Maron");
$newPraticien->setEmail("jeandidier.clement@gmail.com");
$newPraticien->setTelephone("01 02 03 04 05");
$newPraticien->setSpecialite($specialiteRepository->findOneBy(['libelle' => "pédiatrie"]));
print "Praticien créé avec l'id : " . $newPraticien->getId() . "\n";

// Question 6
print PHP_EOL;
displayQuestionHeader(6, "Modifier ce praticien : le rattacher au groupement Bigot, changer sa ville pour Paris et sauvegarder dans la base");
$praticien = $praticienRepository->findOneBy(['id' => "7202b2f8-06be-42da-abf7-c40ac842b827"]);
$praticien->setGroupement($groupementRepository->findOneBy(['nom' => "TELV12"]));
$praticien->setVille("Paris");
$entityManager->flush();

// Question 7
print PHP_EOL;
displayQuestionHeader(7, "Supprimer ce praticien de la base");
$entityManager->remove($praticien);
$entityManager->flush();


