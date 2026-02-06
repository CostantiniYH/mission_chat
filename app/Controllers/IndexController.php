<?php
namespace App\Controllers;

class IndexController
{
    public function index() {
        // Obligation de se connecter pour accéder au chat
        if (!isset($_SESSION['pseudo'])) {
            $e = "Veuillez vous connecter  !";
            header("Location: " . BASE_URL. "login?erreur=$e");
            exit;
        }

        $titre = "Chat yhc";
        $css = "";
        $id = \mysqli_connect("localhost", "root", "", "db_chat");

        // Récupérer les utilisateurs pour les afficher comme des contacts
        $contacts = "SELECT * FROM t_users";
        $users = [];
        $users = \mysqli_query($id, $contacts);

        // Afficher les messages destinés à l'utilisateur connecté et les messages qu'il a lui-même envoyé
        if (isset($id) && isset($_POST['select-contact'])) {    
            $expe = $_POST['contact'];
            $id_user = $_SESSION['id_user'];
            $get_message = "SELECT m.*, u.pseudo AS nom_expe FROM t_messages m 
            INNER JOIN t_users u ON m.expediteur = u.id
            WHERE destinataire = '$id_user' AND expediteur = '$expe' OR expediteur = '$id_user' AND destinataire = '$expe' OR destinataire = 'tous'";
            $posts = [];
            $posts = \mysqli_query($id, $get_message);
        } else {
            $e = 'Veuillez sélectionner un contact pour afficher les messages';
        }

        ob_start();
        require dirname(__DIR__) . "/Views/chat.php";
        $content = ob_get_clean();
        require dirname(__DIR__) . "/Views/partials/layout.php";
    }

    public function post() {
        $id = \mysqli_connect("localhost", "root", "", "db_chat");

        if (isset($_POST['envoyer-message']) && isset($_POST['destinataire'])) {
            $expediteur = $_SESSION['id_user'];
            $message = $_POST['message'];
            $destinataire = $_POST['destinataire'];
            try {
                $stmt = $id->prepare("INSERT INTO t_messages (expediteur, message, date, destinataire)
                VALUES (?, ?, now(), ?)");
                $stmt->bind_param("isi", $expediteur, $message, $destinataire);
                $stmt->execute();
                header("Location: " . BASE_URL);
                exit;
            } catch(\mysqli_sql_exception $e) {
                error_log($e->getMessage());
                echo "Une erreur s'est produite lors de l'envoie du message !";
                header("Location: " . BASE_URL);
                exit;
            }
        } else {
            $e = "Veuillez sélectionner un contact pour envoyer un message.";
                header("Location: " . BASE_URL);
            exit;
        }
    }
}