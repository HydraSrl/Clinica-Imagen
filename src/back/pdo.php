<?php

class DB
{
    private static $pdo;

    public static function getConnection()
    {
        if (self::$pdo === null) {
            include 'db.php';
            try {
                self::$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Could not connect to the database $dbname :" . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}