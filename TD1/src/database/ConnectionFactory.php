<?php

namespace iutnc\hellokant\database;

use PDO;
use PDOException;

class ConnectionFactory
{
    private static ?PDO $pdoInstance = null;

    public static function makeConnection(array $conf): PDO
    {
        if (self::$pdoInstance === null) {

            $dsn = "pgsql:host={$conf['host']};port={$conf['port']};dbname={$conf['dbname']}";
            try {
                self::$pdoInstance = new PDO(
                    $dsn,
                    $conf['username'],
                    $conf['password'],
                );
            } catch (PDOException $e) {
                throw new PDOException("Erreur de connexion : " . $e->getMessage());
            }
        }
        return self::$pdoInstance;
    }

    public static function getConnection(): ?PDO
    {
        return self::$pdoInstance;
    }
}
