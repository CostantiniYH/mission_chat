<nav class="navbar nav bg-body-tertiary bg-opacity-75 fs-4">
    <a class="nav-link text-dark" href="<?= BASE_URL ?>">Chat YHC</a>
    <?php if (isset($_SESSION['id_user']) && $_SESSION['id_user'] == true) : ?>
        <a class="nav-link bi bi-door-open-fill  text-danger" href="logout"></a>
    <?php elseif ($titre == "Inscription") :?>
        <a class="nav-link text-black bi bi-person-circle text-success" href="login">Connexion</a>
    <?php else: ?>
        <a class="nav-link text-dark" href="register">Inscription</a>
    <?php endif ; ?>
</nav>
<header class="bg-warning bg-opacity-50 mb-5 p-5 text-white">
    <h1 class="titre">Chattez avec Devsio-Chat</h1>
</header>