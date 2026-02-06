<?php
namespace App\Config;
use PDO;
use PDOException;

// Connexion DB
$id = mysqli_connect(
    $_ENV['DB_HOST'],
    $_ENV['DB_NAME'],
    $_ENV['DB_USER'],
    $_ENV['DB_PASS']
);

?>