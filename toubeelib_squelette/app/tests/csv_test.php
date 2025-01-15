<?php

// Fonction pour générer une date de naissance aléatoire entre 1950 et 2005
function genererDateNaissanceAleatoire() {
    $timestamp = mt_rand(strtotime('1950-01-01'), strtotime('2005-12-31'));
    return date('Y-m-d', $timestamp);
}

// Fonction pour extraire le prénom et le nom à partir de l'email
function extraireNomPrenom($email) {
    $nomPrenom = explode('@', $email)[0];
    $nomPrenom = preg_replace('/[^a-zA-Z]/', ' ', $nomPrenom); // Remplace les caractères non alphabétiques par des espaces
    $parties = explode(' ', $nomPrenom);
    if (count($parties) > 1) {
        $prenom = ucfirst(strtolower($parties[0]));
        $nom = ucfirst(strtolower(end($parties)));
    } else {
        $prenom = ucfirst(strtolower($parties[0]));
        $nom = 'Unknown';
    }
    return ['prenom' => $prenom, 'nom' => $nom];
}

function genererNumTel() {
    // Générer un numéro aléatoire de mobile (06 ou 07)
    $prefixesMobile = ['06', '07'];
    $prefixesFixe = ['0383', '0297', '0387', '0145', '0472']; // Exemples de préfixes fixes (à adapter selon besoin)

    // Choisir si c'est un numéro mobile ou fixe (50% de chance pour chaque)
    if (rand(0, 1) == 0) {
        // Numéro mobile
        $prefix = $prefixesMobile[array_rand($prefixesMobile)];
        $numero = $prefix . sprintf('%08d', rand(0, 99999999));
    } else {
        // Numéro fixe
        $prefix = $prefixesFixe[array_rand($prefixesFixe)];
        $numero = $prefix . sprintf('%06d', rand(0, 999999));
    }

    return $numero;
}

// Ouverture du fichier CSV
$filename = './praticien.csv'; // Remplacer par le chemin réel du fichier
$handle = fopen($filename, 'r');

if ($handle !== FALSE) {
    // Lecture de chaque ligne du fichier CSV

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $id = $data[0];       // Colonne id
        $email = $data[1];    // Colonne email
        $password = $data[2]; // Colonne password
        $role = $data[3];     // Colonne role

        // Génération du nom, prénom et date de naissance
        $nomPrenom = extraireNomPrenom($email);
        $dateNaiss = genererDateNaissanceAleatoire();
        $numero = genererNumTel();

        // Génération de la requête SQL
        $sql = "('$id', '$email', '$password', $role, '{$nomPrenom['nom']}', '{$nomPrenom['prenom']}', '$numero'),";

        // Affichage ou sauvegarde de la requête
        echo $sql . PHP_EOL;
    }

    // Fermeture du fichier CSV
    fclose($handle);
} else {
    echo "Erreur lors de l'ouverture du fichier CSV.";
}

?>
