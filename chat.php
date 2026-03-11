<?php
// Connexion base de données
$id = mysqli_connect("localhost", "root", "", "db_chat");

// Vérification que l'utilisateur est bien passé par le formulaire 
if(isset($_POST['bouton'])) {

    // Récupérer les données
    $pseudo = $_POST['pseudo'];
    $message = $_POST['message'];

    // Insérer les données (message + pseudo)
    $insert = "INSERT INTO t_messages (expediteur, message, date) 
                VALUES ('$pseudo', '$message', now())";
   
    mysqli_query($id, $insert);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header><h1>Chattez'en direct!!</h1></header>
        <div class="messages">
            <ul>
                <?php
                // Récupérer les messages depuis la base
                $select = "SELECT * FROM t_messages ORDER BY date DESC";
                $resultat = mysqli_query($id, $select);

                // Boucler les résultats et former les données dans un tableau
                while($data = mysqli_fetch_assoc($resultat)) {
                    echo '<li class="mess">'.$data['date'].' : '
                            .$data['expediteur'].' : '.$data['message'].'</li>';
                }
                ?>
            </ul>
        </div>

        <!-- Formulaire d'envoie -->
        <div class="form">
            <form action="" method="post">
                <input type="text" name="pseudo" placeholder="Pseudo :" required>
                <input type="text" name="message" placeholder="Votre message :" required><br>
                <input type="submit" value="Envoyer" name="bouton">
            </form>
        </div>

    </div>
    

 
</body>
</html>