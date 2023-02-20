<?php

namespace Akmal\LoginSystem\Database;

use PDO;

class Database
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection == null) {
//            buat PDO baru
            self::$connection = new PDO(
                dsn: "mysql:host=localhost:3306;dbname=login_system_aselole",
                username: "akmmp",
                password: "root"
            );
        }

        return self::$connection;
    }
}