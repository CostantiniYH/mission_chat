<div class="container">
    <div class="message row border-grey ">
        <h3 class="text-center rounded bg-body-tertiary p-5">Bienvenue <?= $_SESSION['pseudo'] ?></h3><hr>
        <h4 class="text-center mb-5">Vos messages</h4>

        <?php if (isset($_GET['erreur'])) { ?>
            <div class="alert alert-warning"><?= htmlspecialchars($_GET['erreur']) ?></div>
        <?php }  ?>

        <div class="col-md-3 border-top mb-3">
            <form class="form-group formContent" action="" method="post">
                <label class="m-2" for="contact">Contacts</label><br>
                <select class="form-control rounded-4 shadow-sm" name="contact" id="contact">
                    <option value="" class="text-gray">Sélectionner un contact</option>
                    <?php foreach ($users as $contact) { ?>
                        <option value="<?= $contact['id'] ?>"><?= htmlspecialchars($contact['pseudo']) ?></option>
                    <?php } ?>
                </select><br>
                <input class="btn btn-" type="submit" value="Afficher les messages" name="select-contact">
            </form>
        </div>

        <div class="col-md border-start border-top p-1 pt-1 ps-1">
            
            <?php 
            if (isset($posts)) { ?> 

                <button type="button" class="p-3 rounded-circle bg-bleu ">

                <?php 
                foreach ($users as $u) {
                    if ($u['id'] == $_POST['contact'] && $u['id']) {
                        $majExpe = substr($u['pseudo'], 0, 1);
                        echo $majExpe;
                        break;
                    }
                } 
                ?>

                </button>
                
                <ul class="list-group gap-3 ps-5 pb-2">
                
                <?php 
                if (!empty($posts)) {
                    foreach ($posts as $post) {
                        if ($post['nom_expe'] === $_SESSION['pseudo']) {
                            $float = "bg-self";
                            $post['nom_expe'] = 'Vous';
                            } else {
                            $float = "ms-auto bg-foreign";
                        }
                ?>

                <li class="list-group-item text-white rounded-5 w-50 <?= $float ?>">
                    <h5><?= $post['nom_expe'] ?></h5>
                    <p><?= $post['message'] ?></p>
                    <small><?= $post['date'] ?></small>
                </li>
                
            <?php 
                    }
                }  else { ?>
                <div class="alert alert-warning">Vous n'avez aucun message de <?php 
                    foreach ($users as $u){
                        if ($u['id'] == $_POST['contact'] && $_POST['contact'] != $_SESSION['id_user']){
                            echo $u['pseudo']."." ;
                            break;
                        } else {
                            echo "vous.";
                            break;
                        }
                    }?>
                </div>
            <?php
            } 
            } 
            ?>
            </ul>
        </div>
        <hr class="">
        <div class="p-5">
            <form class="form-group formContent" method="post" action="post">
                <label class="m-2" for="destinataire">Contacts</label><br>
                <select class="form-control rounded-4 shadow-sm" name="destinataire" id="destinataire">
                    <option value="" class="text-gray">Sélectionner un contact</option>
                    <?php foreach ($users as $dest) { ?>
                        <option value="<?= $dest['id'] ?>"><?= htmlspecialchars($dest['pseudo']) ?></option>
                    <?php } ?>
                    <option value="all">Tous</option>
                </select><br>

                <div class="position-relative">
                    <textarea class="form-control mb-3 shadow rounded-5" name="message" id="" placeholder="Message..." required></textarea>
                    <button class="position-absolute top-50 end-0 translate-middle-y me-2 btn rounded-circle text-white bi bi-send" 
                    type="submit" name="envoyer-message" value="Envoyer">
                </div>
            </form>
        </div>
    </div>
</div>