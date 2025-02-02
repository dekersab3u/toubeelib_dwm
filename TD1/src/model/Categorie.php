<?php

namespace iutnc\hellokant\model;

class Categorie extends Model
{
    protected static string $table = 'categorie';

    public function articles(): array {
        return $this->has_many(Article::class, 'id_categ');
    }
}
