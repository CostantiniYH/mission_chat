<main class="container">
    <?php if (isset($e) && !empty($e)) { ?>
        <div class="alert alert-warning"><?= $e ?></div>
    <?php }  ?>
    <form class="col-md-8 rounded form shadow p-5 mx-auto bg-light" action="login" method="post">
        <?php if(isset($_GET['erreur'])) { ?> <div class="alert alert-warning"><?= $_GET['erreur'] ?></div> <?php } ?>
        <h1 class="text-center mb-4">Connexion</h1>
        <div class="input-group">                
            <input class=" input-box" type="text" name="email" id="email" placeholder="" required>
            <label class="label" for="">Email</label>
        </div>
        <div class="input-group">                
            <input class=" mb-4 input-box" type="password" name="password" id="password" placeholder="" required>
            <label class="label" for="">Mot de passe</label>
        </div>
        <input class="form-control btn text-white" type="submit" name="connexion" value="Se connecter">
    </form>
</main>