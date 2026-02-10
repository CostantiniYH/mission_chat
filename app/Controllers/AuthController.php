<?php
namespace App\Controllers;
use App\Config\Database;
use PDO;

class AuthController
{
    public function formRegister() {
        $titre = "Inscription";
        $css = "register";

        ob_start();
        require dirname(__DIR__) . "/Views/register.php";
        $content = ob_get_clean();
        require dirname(__DIR__) . "/Views/partials/layout.php";
    }

    public function register() {
        if (isset($_POST["inscription"])) {
            $pseudo = $_POST['pseudo'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];            

            if ($password !== $password2) {
                $_SESSION['erreur'] = "Les mots de passes ne correspondent pas !";
                header("Location: " . BASE_URL ."register");
                exit();
            }

            $pdo = Database::connect();
            
            $sql = "SELECT * FROM t_users WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $userExist = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];


            if ($userExist) {
                $_SESSION['erreur'] = "Email déjà utilisé.";
                header("Location: ".BASE_URL."register");
                exit;
            } 

            $password = password_hash($password, PASSWORD_ARGON2ID);

            
                $sql = "INSERT INTO t_users (pseudo, email, password) 
                VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$pseudo, $email, $password]);

                $_SESSION['success'] = "Inscription réussi !";
                header("Location: " . BASE_URL. "login");
                exit();
            
        } else {
            $_SESSION['erreur'] = "Une erreur s'est produite.";
            header("Location: " . BASE_URL ."register");
            exit();
        }
    }

    public function formLogin() {
        $titre = "Connexion";
        $css = "";

        ob_start();
        require dirname(__DIR__) . "/Views/login.php";
        $content = ob_get_clean();
        require dirname(__DIR__) . "/Views/partials/layout.php";
    }

    public function login() {
        if (isset($_POST["connexion"])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $pdo = Database::connect();
            
            $sql = "SELECT * FROM t_users WHERE email = ?";            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $ligne = $result;

            if ($result == false) {
                $_SESSION['erreur'] = "Email invalide !";
                header("Location: " . BASE_URL . "login");
                exit();
            }

            if (!password_verify($password, $ligne['password'])) {
                $_SESSION['erreur'] = "Mot de passe incorrecte.";
                header("Location: " . BASE_URL . "login");
                exit();
            } else {
                $_SESSION['id_user'] = $ligne['id'];
                $_SESSION['pseudo'] = $ligne['pseudo'];
                $_SESSION['email'] = $ligne['email'];
                $_SESSION['role'] = $ligne['role'];
                $_SESSION['logged_in'] = true;
                header("Location: " . BASE_URL);
                exit();
            }
        } else {
            $_SESSION['erreur'] = "Une erreur s'est produite.";
            header("Location: " . BASE_URL ."login");
            exit();
        }

    }

    public function logout() {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        $_SESSION['info'] = "Vous vous êtes déconnecté avec succès !";
        header("Location: " . BASE_URL. "login");
        exit();
    }
}
