<?php
namespace App\Core;

interface Middleware
{
    public function handle($next);
}

// if ($_SESSION['role'] !== 'admin') {
//     echo '<div class="alert alert-danger">Accès interdit !</div>';
//     header("Location: " . BASE_URL);
// }