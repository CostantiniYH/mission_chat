<?php
namespace App\Config;
use PDO;
use PDOException;
// Connexion DB
// $id = mysqli_connect(
//     $_ENV['DB_HOST'],
//     $_ENV['DB_USER'],
//     $_ENV['DB_PASS'],
//     $_ENV['DB_NAME']
// );

class Database
{
    public static function connect() {
        $host    = $_ENV['DB_HOST'];
        $user    = $_ENV['DB_USER'];
        $pass    = $_ENV['DB_PASS'];
        $db_name = $_ENV['DB_NAME'];

        $dsn = "mysql:host=$host;dbname=$db_name";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
            return $pdo;
        } catch(PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());            
        }

    }
}

?>