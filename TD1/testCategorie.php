<?php

require_once __DIR__ . '/vendor/autoload.php';

use iutnc\hellokant\database\ConnectionFactory;
use iutnc\hellokant\model\Article;
use iutnc\hellokant\model\Categorie;

$conf = parse_ini_file(__DIR__ . '/conf/db.conf.ini');
$pdo = ConnectionFactory::makeConnection($conf);


$article = Article::find(64)[0];
$categorie = $article->categorie();
if ($categorie) {
    echo "Catégorie de l'article '{$article->nom}' : {$categorie->nom}\n";
}


$categorie = Categorie::find(1)[0];
$articles = $categorie->articles();
echo "Articles dans la catégorie '{$categorie->nom}':\n";
foreach ($articles as $article) {
    echo "- {$article->nom}\n";
}
