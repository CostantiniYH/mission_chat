<main class="container">
    <?php  
        // Déterminer la couleur selon le type de message
        if (isset($_GET['erreur'])) {
            $color = 'danger';
        } elseif (isset($_GET['success'])) {
            $color = 'success';
        } elseif (isset($_GET['info'])) {
            $color = 'info';
        } else {
            $color = 'secondary';
        }
        ?>

        <?php if(isset($_GET['erreur']) || isset($_GET['success']) || isset($_GET['info'])): ?>
            <div class="alert alert-<?= $color ?> alert-dismissible fade show">
                <?php 
                    if(isset($_GET['erreur'])) {
                        echo htmlspecialchars($_GET['erreur']);
                    } elseif(isset($_GET['success'])) {
                        echo htmlspecialchars($_GET['success']);
                    } elseif (isset($_GET['info'])) {
                        echo htmlspecialchars($_GET['info']);
                    }
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div> 
        <?php endif; ?>
    <form class="col-md-8 rounded form shadow p-5 mx-auto bg-light" action="<?= BASE_URL ?>login" method="post">
        
        

        <h1 class="text-center mb-4">Connexion</h1>
        <div class="input-group">                
            <input class="input-box" type="text" name="email" id="email" placeholder="" required>
            <label class="label" for="email">Email</label>
        </div>
        <div class="input-group">                
            <input class="mb-4 input-box" type="password" name="password" id="password" placeholder="" required>
            <label class="label" for="password">Mot de passe</label>
        </div>
        <input class="form-control btn text-white" type="submit" name="connexion" value="Se connecter">
    </form>
</main>