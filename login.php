<?php
session_start();
if (isset($_POST["connexion"])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    include ('connect.php');
    
    $sql = "SELECT * FROM t_users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($id, $sql);

    if (mysqli_num_rows($result) == 0) {
        $error = "Email ou mot de passe invalide.";
    } else {
        $ligne = mysqli_fetch_assoc($result);
        $_SESSION['id_user'] = $ligne['id'];
        $_SESSION['pseudo'] = $ligne['pseudo'];
        $_SESSION['email'] = $ligne['email'];
        $_SESSION['role'] = $ligne['role'];
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login.css">
    <title>Connexion</title>
</head>
<body>
    <nav class="navbar nav bg-body-tertiary bg-opacity-75 mb-5 fs-4">
        <a class="nav-link text-dark" href="index.php">Chat</a>
        <a class="nav-link text-dark" href="register.php">Inscription</a>

    </nav>
    <main class="container">
        
        <form class="col-md-8 rounded form shadow p-5 mx-auto bg-light" action="" method="post">
            <h1 class="text-center mb-4">Connexion</h1>
            <?php if (isset($error)) { ?>
            <p class="alert alert-danger mt-3"> <?= $error ?></p>
            <?php } ?>
            <label for="">Email</label>
            <input class="form-control" type="text" name="email" id="email" placeholder="Entrer le email" required>
            <label for="">Mot de passe</label>
            <input class="form-control mb-4" type="password" name="password" id="password" placeholder="Entrer le mot de passe" required>
            <input class="form-control btn text-white" type="submit" name="connexion" value="Se connecter">
        </form>
    </main>
</body>
</html>