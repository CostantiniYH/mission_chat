<?php
session_start();
if (!isset($_SESSION['pseudo'])) {
    $e = "Veuillez vous onnectez-vous !";
    header("Location: login.php?erreur=$e");
    exit;
}
$id = mysqli_connect("localhost", "root", "", "db_chat");

$contacts = "SELECT * FROM t_users";
$users = [];
$users = mysqli_query($id, $contacts);

if (isset($_POST['envoyer'])) {
    $expediteur = $_SESSION['id_user'];
    $message = $_POST['message'];
    $destinataire = $_POST['destinataire'];
    $stmt = $id->prepare("INSERT INTO t_messages (expediteur, message, date, destinataire)
    VALUES (?, ?, now(), ?)");
    $stmt->bind_param("isi", $expediteur, $message, $destinataire);
    var_dump($stmt);
    $stmt->execute();
    header("Location: index.php");
    exit();
}

if (isset($id)) {    
    $id_user = $_SESSION['id_user'];
    $get_message = "SELECT m.*, u.pseudo AS nom_expe FROM t_messages m 
    INNER JOIN t_users u ON m.expediteur = u.id
    WHERE destinataire = '$id_user' OR expediteur = '$id_user'";
    $posts = [];
    $posts = mysqli_query($id, $get_message);
}

// session_destroy();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Chat yhc</title>
</head>
<body>
    <nav class="navbar nav bg-body-tertiary bg-opacity-75 fs-4">
        <!-- <a class="nav-link text-dark" href="register.php">Inscription</a>
        <a class="nav-link text-black" href="login.php">Connexion</a> -->
        <a class="nav-link bi bi-door-open-fill  text-danger" href="logout.php"></a>
    </nav>
    <header class="bg-warning bg-opacity-50 mb-5 p-5 text-white">
        <h1 class="titre">Chattez avec Devsio-Chat</h1>
    </header>
    <div class="container">
        <div class="message border-grey m-3">
        <h3 class="text-center mb-5">Bienvenue <?= $_SESSION['pseudo'] ?></h3><hr>

            <ul class="list-group gap-3">
                <?php 
                    foreach ($posts as $post) {
                        if ($post['nom_expe'] === $_SESSION['pseudo']) {
                            $float = "ms-auto bg-self";
                        } else {
                            $float = "bg-foreign";
                        }
                ?>

                <li class="list-group-item text-white rounded-5 w-50 <?= $float ?>">
                    <h5><?= $post['nom_expe'] ?></h5>
                    <p><?= $post['message'] ?></p>
                    <small><?= $post['date'] ?></small>
                </li>
                <?php } ?>
            </ul>
            <hr>
            <div class="p-5">
                <form class="form-group" method="post" class="formContent">
                    <label class="m-2" for="destinataire">Contacts</label><br>
                    <select class="form-control rounded-4 shadow-sm" name="destinataire" id="destinataire">
                        <option value="" class="text-gray">Sélectionner un contact</option>
                        <?php foreach ($users as $dest) { ?>
                        <option value="<?= $dest['id'] ?>"><?= $dest['pseudo'] ?></option>
                        <?php } ?>
                    </select><br>
                    <!-- <label for="message">Entrer votre message</label><br> -->
                     <div class="position-relative">
                         <textarea class="form-control mb-3 shadow rounded-5" name="message" id="" placeholder="Message..." required></textarea>
                         <button class="position-absolute top-50 end-0 translate-middle-y me-2 btn rounded-circle text-white bi bi-send" type="submit" name="envoyer" value="Envoyer">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>