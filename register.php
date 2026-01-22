<?php
if (isset($_POST["S'inscrire"])) {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    include ('connect.php');
    
    $sql = "SELECT * FROM t_users WHERE email = '$email'";
    $result = mysqli_query($id, $sql);

    if (mysqli_num_rows($result) > 0) {
        $error_email = "Email déjà utilisé.";
    } else {
        $add_user = "INSERT INTO t_users (pseudo, email, password) 
        VALUES ('$pseudo', '$email', '$password')";
        mysqli_query($id, $add_user);
        header("Location: login.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="register.css">
    <title>Inscription</title>
</head>
<body>
    <nav class="navbar nav bg-body-tertiary bg-opacity-75 mb-5 fs-4">
        <a class="nav-link text-dark" href="index.php">Chat</a>
        <a class="nav-link text-black" href="login.php">Connexion</a>
    </nav>
    <main class="container">
        
        <form class="col-md-8 rounded form shadow p-5 mx-auto bg-light" action="" method="post">
            <h1 class="text-center mb-4">Inscription</h1>
            <label for="">Pseudo</label>    
            <input class="form-control" type="text" name="pseudo" id="pseudo" placeholder="Entrer le pseudo" required>
            <label for="">Email</label>
            <input class="form-control" type="text" name="email" id="email" placeholder="Entrer le email" required>
            <?php if (isset($error_email)) { ?>
            <p class="alert alert-danger mt-3"> <?= $error_email ?></p>
            <?php } ?>
            <label for="">Mot de passe</label>
            <input class="form-control" type="password" name="password" id="password" placeholder="Entrer le mot de passe" required>
            <label for="">Confirmer le mot de passe</label>
            <input class="form-control" type="password" name="password2" id="password2" placeholder="Confirmer le mot de passe" required>
            <label for=""></label>
            <input class="form-control btn text-white" type="submit" name="S'inscrire" value="S'inscrire">
        </form>
    </main>
</body>
</html>