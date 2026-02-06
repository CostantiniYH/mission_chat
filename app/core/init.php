<?php
use App\Core\Router;
use App\Config\Database;
require_once dirname(__DIR__) . '/config/config.php';

$router = new Router();

require dirname(__DIR__) . "/routes/web.php";

try {
    $response = $router->dispatch(
        $_SERVER['REQUEST_METHOD'],
        $_SERVER['REQUEST_URI']
    );

    echo $response;
} catch (\Exception $e) {
    // Gestion d'erreur simple pour l'instant
    http_response_code($e->getCode() ?: 500);
    echo '<h1>Erreur : ' . htmlspecialchars($e->getMessage()) . '</h1>';
}