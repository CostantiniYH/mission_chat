<main class="container">
    <form class="col-md-8 rounded form shadow p-5 mx-auto bg-light" action="<?= BASE_URL ?>register" method="post">      
        <?php if(isset($e)) { ?>
            <div class="alert alert-danger"><?= htmlspecialchars($e) ?></div> 
        <?php } ?>
    
        <h1 class="text-center mb-4">Inscription</h1>
        <div class="input-group">                
            <input class="input-box" type="text" name="pseudo" id="pseudo" placeholder="" required>
            <label class="label" for="pseudo">Pseudo</label>    
        </div>
        <div class="input-group">                
            <input class="input-box" type="text" name="email" id="email" placeholder="" required>
            <label class="label" for="email">Email</label>
        </div>        
        <div class="input-group">                
            <input class="input-box" type="password" name="password" id="password" placeholder="" required>
            <label class="label" for="password">Mot de passe</label>
        </div>
        <div class="input-group">                
            <input class="input-box" type="password" name="password2" id="password2" placeholder="" required>
            <label class="label" for="password2">Confirmer le mot de passe</label>
        </div>
        <input class="form-control btn text-white" type="submit" name="inscription" value="S'inscrire">
    </form>
</main>
