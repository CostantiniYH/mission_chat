<main class="container">   
    <form class="col-md-8 rounded form shadow p-5 mx-auto bg-light" action="<?= BASE_URL ?>login" method="post">
        
        <?php require __DIR__ . "/partials/alert.php"; ?>
        
        <h1 class="text-center mb-4">Connexion</h1>
        <div class="input-group">                
            <input class="input-box" type="text" name="email" id="email" placeholder="" required>
            <label class="label" for="email">Email</label>
        </div>
        <div class="input-group">                
            <input class="mb-2 input-box" type="password" name="password" id="password" placeholder="" required>
            <label class="label" for="password">Mot de passe</label>
        </div>
        <input class="form-control btn text-white mb-4" type="submit" name="connexion" value="Se connecter">
        <p>Créer votre compte ici : 
            <a class="" href="register">Inscription</a>
        </p>
    </form>
</main>