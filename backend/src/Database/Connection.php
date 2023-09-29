<?php

namespace Bm\Store\Database;

use Bm\Store\Config\Enviroment;
use PDO;

class Connection
{
    private static ?PDO $connection = null;

    public static function connect()
    {
        $host = Enviroment::getEnv('DB_HOST');
        $dbname = Enviroment::getEnv('DB_DATABASE');
        $username = Enviroment::getEnv('DB_USERNAME');
        $password = Enviroment::getEnv('DB_PASSWORD');
        $driver = Enviroment::getEnv('DB_DRIVER');
        $port = Enviroment::getEnv('DB_PORT');
        
        if (!self::$connection) {
            $dsn = $driver . ':host=' . $host . ';port=' . $port . ';dbname=' . $dbname . ';';
            self::$connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
        }

        return self::$connection;
    }
}
