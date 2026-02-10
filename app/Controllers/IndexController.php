<?php
namespace App\Controllers;
use App\Config\Database;
use Exception;
use PDO;

class IndexController
{
    private $pdo;
    public function __construct() 
    {
        $this->pdo = Database::connect();
    }
    public function index() {
        // Obligation de se connecter pour accéder au chat
        if (!isset($_SESSION['pseudo'])) {
            $_SESSION['info'] = "Veuillez vous connecter  !";
            header("Location: " . BASE_URL. "login");
            exit();
        }

        
        if (isset($_POST['select-contact']) && empty($_POST['contact']) ) {
            $_SESSION['info'] = 'Veuillez sélectionner un contact pour afficher les messages';            
            header("Location: " . BASE_URL);
            exit();
        }

        $titre = "Chat yhc";
        $css = "";

        $pdo = $this->pdo;

        // Récupérer les utilisateurs pour les afficher comme des contacts
        try {

            $sql = "SELECT * FROM t_users ORDER BY pseudo ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([]);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch(\PDOException $e) {
            throw new Exception("Une erreur s'est produite !");
        }

        // Afficher les messages destinés à l'utilisateur connecté et les messages qu'il a lui-même envoyé
        if (isset($pdo) && isset($_POST['select-contact']) && !empty($_POST['contact'])) {    
            $expe = $_POST['contact'] ?? null;
            $id_user = $_SESSION['id_user'];

            try {     
                $pdo = $this->pdo; // Connexion DB

                $sql = "SELECT m.*, u.pseudo AS nom_expe FROM t_messages m 
                INNER JOIN t_users u ON m.expediteur = u.id
                WHERE (m.expediteur = ? AND  m.destinataire = ?) 
                    OR (m.expediteur = ? AND m.destinataire = ?) 
                    OR (m.expediteur = ? AND m.is_public = TRUE)
                    ORDER BY m.date ASC"; // Classer par ordre d'envoie
                $stmt = $pdo->prepare($sql);
                // Les 4 paramètres servent à afficher : 
                //      les messages du contact sélectionné ($expe) à l'utilisateur ($id_user), 
                //      les messages de l'utilisateur ($id_user) au contact sélectionné ($expe)
                //      les messages destinés à tous les contacts
                $stmt->execute([$expe, $id_user, $id_user, $expe, $expe]);
                $posts = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
            } catch(\PDOException $e) {
                throw new Exception("Une erreur s'est produite lors du chargement des messages !" . $e->getMessage());
            }
        }
        

        ob_start();
        require dirname(__DIR__) . "/Views/chat.php";
        $content = ob_get_clean();
        require dirname(__DIR__) . "/Views/partials/layout.php";
    }

    public function post() {

        if (isset($_POST['envoyer-message']) && !empty($_POST['destinataire'])) {
            $expediteur = $_SESSION['id_user'];
            $message = $_POST['message'];
            $destInput = $_POST['destinataire'];

            if ($destInput === "all" || $destInput === "0" || empty($destInput)) {
                $destId = null;  // PHP transmettra un vrai NULL à PDO
                $isPublic = 1;   // Ton nouveau flag booléen
            } else {
                $destId = (int)$destInput; // C'est un ID d'utilisateur réel
                $isPublic = 0;
            }

            try {
                $pdo = $this->pdo; // Connexion DB

                $stmt = $pdo->prepare("INSERT INTO t_messages (expediteur, destinataire, message, is_public)
                VALUES (?, ?, ?, ?)");
                $stmt->execute([$expediteur, $destId, $message, $isPublic]);
                header("Location: " . BASE_URL);
                exit();
            } catch(\PDOException $e) {
                error_log($e->getMessage());
                $_SESSION['erreur'] = "Une erreur s'est produite lors de l'envoie du message !";
                header("Location: " . BASE_URL);
                exit();
            }
        } 

        if (isset($_POST['envoyer-message']) && empty($_POST['destinataire'])) {
            $_SESSION = "Veuillez sélectionner un contact pour envoyer un message.";
            header("Location: " . BASE_URL);
            exit();
        }
    }
}
