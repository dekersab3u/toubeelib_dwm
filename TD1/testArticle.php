<?php

require_once __DIR__ . '/vendor/autoload.php';

use iutnc\hellokant\database\ConnectionFactory;
use iutnc\hellokant\model\Article;

$conf = parse_ini_file(__DIR__ . '/conf/db.conf.ini');
$pdo = ConnectionFactory::makeConnection($conf);


$article = new Article([
    'nom' => 'Monopoly',
    'descr' => 'Jeu de société en famille',
    'tarif' => 49.99,
    'id_categ' => 1
]);

$article->insert();
echo "Article inséré avec l'ID : " . $article->id . "\n";

$article->delete();
echo "Article supprimé avec l'ID : " . $article->id . "\n";


echo "Tous les articles :\n";
$articles = Article::all();
foreach ($articles as $article) {
    echo "ID: {$article->id}, Nom: {$article->nom}\n";
}


echo "\nTrouver un article par ID :\n";
$articleById = Article::find(1);
foreach ($articleById as $article) {
    echo "ID: {$article->id}, Nom: {$article->nom}\n";
}


echo "\nTrouver des articles avec un tarif <= 100 :\n";
$articlesByCriteria = Article::find(['tarif', '<=', 100], ['id', 'nom', 'tarif']);
foreach ($articlesByCriteria as $article) {
    echo "ID: {$article->id}, Nom: {$article->nom}, Tarif: {$article->tarif}\n";
}
