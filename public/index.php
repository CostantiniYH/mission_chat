<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Démarrer la session (toujours au début du fichier). Ici, la session est démarrée à la page index.php
// qui est la seule sur laquelle tourne le site ce qui réduit la redondance (MVC).

require dirname(__DIR__) . "/vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
require_once dirname(__DIR__) . '/app/config/config.php';

require dirname(__DIR__) . "/app/core/init.php";
