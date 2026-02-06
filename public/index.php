<?php
// Démarrer la session (toujours au début du fichier). Ici, la session est démarrée à la page index.php
// qui est la seule sur laquelle tourne le site ce qui réduit la redondance (MVC).
session_start();

require dirname(__DIR__) . "/vendor/autoload.php";
require dirname(__DIR__) . "/app/core/init.php";