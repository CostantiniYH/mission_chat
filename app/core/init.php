<?php
use App\Core\Router;

$router = new Router();

require dirname(__DIR__) . "/routes/web.php";

try {
    $response = $router->dispatch(
        $_SERVER['REQUEST_METHOD'],
        $_SERVER['REQUEST_URI']
    );

    echo $response;
} catch (\Exception $e) {
    // On vérifie si le code est un entier valide pour HTTP, sinon on met 500
    $code = is_int($e->getCode()) && $e->getCode() >= 100 && $e->getCode() < 600 
            ? $e->getCode() 
            : 500;

    http_response_code($code);
    
    // Pour t'aider à débugger, affiche le vrai code SQL en log ou à l'écran :
    echo "Erreur système : " . $e->getMessage() . " (Code SQL: " . $e->getCode() . ")";
    exit;
}
