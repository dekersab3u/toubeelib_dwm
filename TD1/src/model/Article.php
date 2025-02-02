<?php

namespace iutnc\hellokant\model;

class Article extends Model
{
    protected static string $table = 'article';

    public function categorie(): Model
    {
        return $this->belongs_to(Categorie::class, 'id_categ');
    }
}
