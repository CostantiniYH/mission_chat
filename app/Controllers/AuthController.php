<?php
namespace App\Controllers;
use App\Config\Database;
use PDO;

class AuthController
{
    public function formRegister() {
        $titre = "Inscription";
        $css = "register";
        $e = $_GET['erreur'] ?? null;

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
                $e = "Les mots de passes ne correspondent pas !";
                header("Location: " . BASE_URL ."register?erreur=" . urlencode($e));
                exit();
            }

            $pdo = Database::connect();
            
            $sql = "SELECT * FROM t_users WHERE email = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email]);
            $userExist = $stmt->fetch(PDO::FETCH_ASSOC) ?? [];


            if ($userExist) {
                $e = "Email déjà utilisé.";
                header("Location: ".BASE_URL."register?erreur=" . urlencode($e));
                exit;
            } 

            $password = password_hash($password, PASSWORD_ARGON2ID);

            
                $sql = "INSERT INTO t_users (pseudo, email, password) 
                VALUES (?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$pseudo, $email, $password]);

                $success = "Inscription réussi !";
                header("Location: " . BASE_URL. "login?success=" . urlencode($success));
                exit();
            
        } else {
            $e = "Une erreur s'est produite.";
            header("Location: " . BASE_URL ."register?erreur=" . urlencode($e));
            exit();
        }
    }

    public function formLogin() {
        $titre = "Connexion";
        $css = "";
        $e = $_GET['erreur'] ?? '';

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
                $e = "Email invalide !";
                header("Location: " . BASE_URL . "login?erreur=" . urldecode($e));
                exit();
            }

            if (!password_verify($password, $ligne['password'])) {
                $e = "Mot de passe incorrecte.";
                header("Location: " . BASE_URL . "login?erreur=" . urlencode($e));
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
            $e = "Une erreur s'est produite.";
            header("Location: " . BASE_URL ."login?erreur=" . urlencode($e));
            exit();
        }

    }

    public function logout() {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        $info = "Vous êtes déconnecté";
        header("Location: " . BASE_URL. "login?info=" . urlencode($info));
        exit();
    }
}
