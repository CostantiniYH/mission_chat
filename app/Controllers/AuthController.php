<?php
namespace App\Controllers;

class AuthController
{
    public function formRegister() {
        $titre = "Inscription";
        $css = "register";
        $e = $_GET['e'] ?? '';

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
                header("Location: " . BASE_URL ."register?e=$e");
                exit;
            }

            $password = password_hash($password, PASSWORD_ARGON2ID);

            require dirname(__DIR__) . "/config/Database.php";
            
            $sql = "SELECT * FROM t_users WHERE email = '$email'";
            $result = \mysqli_query($id, $sql);

            if (\mysqli_num_rows($result) > 0) {
                $error_email = "Email déjà utilisé.";
            } else {
                $add_user = "INSERT INTO t_users (pseudo, email, password) 
                VALUES ('$pseudo', '$email', '$password')";
                \mysqli_query($id, $add_user);
                header("Location: " . BASE_URL. "login");
            }
        } else {
            $e = "Une erreur s'est produite.";
            header("Location: " . BASE_URL ."register?e=$e");
            exit;
        }
    }

    public function formLogin() {
        $titre = "Connexion";
        $css = "";
        $e = $_GET['e'] ?? '';

        ob_start();
        require dirname(__DIR__) . "/Views/login.php";
        $content = ob_get_clean();
        require dirname(__DIR__) . "/Views/partials/layout.php";
    }

    public function login() {
        if (isset($_POST["connexion"])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            require dirname(__DIR__) . "/config/Database.php";
            
            $sql = "SELECT * FROM t_users WHERE email = '$email'";
            $result = \mysqli_query($id, $sql);

            $ligne = \mysqli_fetch_assoc($result);

            if (\mysqli_num_rows($result) == 0) {
                $e = "Email invalide.";
                header("Location: " . BASE_URL . "login?e=$e");
                exit;
            }

            if (!password_verify($password, $ligne['password'])) {
                $e = "Mot de passe incorrecte.";
                return header("Location: " . BASE_URL . "login?e=$e");
            } else {
                $_SESSION['id_user'] = $ligne['id'];
                $_SESSION['pseudo'] = $ligne['pseudo'];
                $_SESSION['email'] = $ligne['email'];
                $_SESSION['role'] = $ligne['role'];
                $_SESSION['logged_in'] = true;
                header("Location: " . BASE_URL);
                exit;
            }
        } else {
            $e = "Une erreur s'est produite.";
            header("Location: " . BASE_URL ."login?e=$e");
            exit;
        }

    }

    public function logout() {
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        header("Location: " . BASE_URL. "login");
        exit;
    }
}