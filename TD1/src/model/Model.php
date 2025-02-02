<?php

namespace iutnc\hellokant\model;

use iutnc\hellokant\query\Query;

abstract class Model
{
    protected array $atts = [];
    protected static string $table;
    protected static string $idColumn = 'id';

    public function __construct(array $t = null) {
        if (!is_null($t)) $this->atts = $t;
    }

    public function __get(string $name): mixed {
        if (array_key_exists($name, $this->atts))
            return $this->atts[$name];
        return null;
    }

    public function __set(string $name, $value) {
        $this->atts[$name] = $value;
    }

    public function delete(): void {
        if (!isset($this->atts[static::$idColumn])) {
            throw new \Exception("Impossible de supprimer un objet sans clé primaire définie.");
        }

        Query::table(static::$table)
            ->where(static::$idColumn, '=', $this->atts[static::$idColumn])
            ->delete();
    }

    public function insert(): void {
        $id = Query::table(static::$table)->insert($this->atts);
        $this->atts[static::$idColumn] = $id;
    }

    public static function all(): array {
        $lignes = Query::table(static::$table)->get();
        return array_map(fn($ligne) => new static($ligne), $lignes);
    }

    public static function find(mixed $critere, array $colonnes = ['*']): array {
        $query = Query::table(static::$table)->select($colonnes);

        if (is_int($critere)) {
            $query = $query->where(static::$idColumn, '=', $critere);
        } elseif (is_array($critere)) {
            [$col, $op, $val] = $critere;
            $query = $query->where($col, $op, $val);
        }

        $rows = $query->get();
        return array_map(fn($row) => new static($row), $rows);
    }


    public function belongs_to(string $model, string $cle_etrangere): ?Model {

        if (!is_subclass_of($model, Model::class)) {
            throw new \Exception("$model n'est pas un modèle valide.");
        }

        $table_associe = $model::$table;
        $cle_associe = $model::$idColumn;

        $valeur = $this->atts[$cle_etrangere] ?? null;
        if (!$valeur) {
            return null;
        }

        $row = Query::table($table_associe)
            ->where($cle_associe, '=', $valeur)
            ->get();

        if(!empty($row)){
            return new $model($row[0]);
        } else {
            return null;
        }
    }



    public function has_many(string $model, string $cle_etrangere): array {

        if (!is_subclass_of($model, Model::class)) {
            throw new \Exception("$model n'est pas un modèle valide.");
        }

        $table_associe = $model::$table;
        $primaryKeyValue = $this->atts[static::$idColumn] ?? null;

        if (!$primaryKeyValue) {
            return [];
        }

        $rows = Query::table($table_associe)
            ->where($cle_etrangere, '=', $primaryKeyValue)
            ->get();

        return array_map(fn($row) => new $model($row), $rows);
    }

}

