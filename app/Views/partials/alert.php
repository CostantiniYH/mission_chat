<?php  
    // Déterminer la couleur selon le type de message
    if (isset($_SESSION['erreur'])) {
        $color = 'danger';
    } elseif (isset($_SESSION['success'])) {
        $color = 'success';
    } elseif (isset($_SESSION['info'])) {
        $color = 'info';
    } else {
        $color = 'secondary';
    }
    
    if(isset($_SESSION['erreur']) || isset($_SESSION['success']) || isset($_SESSION['info'])): ?>

    <div class="alert alert-<?= $color ?> alert-dismissible fade show">

        <?php 
            if(isset($_SESSION['erreur'])) {
                echo htmlspecialchars($_SESSION['erreur']);
            } elseif(isset($_SESSION['success'])) {
                echo htmlspecialchars($_SESSION['success']);
            } elseif (isset($_SESSION['info'])) {
                echo htmlspecialchars($_SESSION['info']);
            }
        ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div> 

<?php endif; ?>