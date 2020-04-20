<?php

class Database
{
    protected static $pdo;

    public static function getInstance()
    {
        if (empty(self::$pdo)) {
            self::$pdo = new pdo(
                'mysql:host=localhost;dbname=beebee;charset=utf8',
                'root',
                '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            );

        }
        return self::$pdo;
    }




}


?>