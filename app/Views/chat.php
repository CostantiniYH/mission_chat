<div class="container">
    <div class="message row border-grey ">
        <h3 class="text-center rounded bg-body-tertiary p-5">Bienvenue <?= $_SESSION['pseudo'] ?></h3><hr>
        <h4 class="text-center mb-5">Vos messages</h4>

        <?php if (isset($e)) { ?>
            <div class="alert alert-warning"><?= $e ?></div>
        <?php }  ?>

        <div class="col-md-3 border-top mb-3">
            <form class="form-group formContent" action="" method="post">
                <label class="m-2" for="contact">Contacts</label><br>
                <select class="form-control rounded-4 shadow-sm" name="contact" id="contact">
                    <option value="" class="text-gray">Sélectionner un contact</option>
                    <?php foreach ($users as $dest) { ?>
                    <option value="<?= $dest['id'] ?>"><?= $dest['pseudo'] ?></option>
                    <?php } ?>
                </select><br>
                <input class="btn btn-" type="submit" value="Afficher les messages" name="select-contact">
            </form>
        </div>

        <div class="col-md border-start border-top p-1 pt-1 ps-1">
            
            <button type="button" class="p-3 rounded-circle bg-bleu ">
                <?php if (isset($posts)) foreach ($posts as $post) {
                if ($post['nom_expe'] !== $_SESSION['pseudo']) {
                    $majExpe = substr($post['nom_expe'], 0, 1);
                    echo $majExpe;
                }
                } ?>
            </button>
            <ul class="list-group gap-3 ps-5 pb-2">
                <?php 
                if (isset($posts)) {
                    foreach ($posts as $post) {
                        if ($post['nom_expe'] === $_SESSION['pseudo']) {
                            $float = "ms-auto bg-self";
                            $post['nom_expe'] = 'Vous';
                        } else {
                            $float = "bg-foreign";
                        }
                ?>

                <li class="list-group-item text-white rounded-5 w-50 <?= $float ?>">
                    <h5><?= $post['nom_expe'] ?></h5>
                    <p><?= $post['message'] ?></p>
                    <small><?= $post['date'] ?></small>
                </li>
                <?php }
                }; ?>
            </ul>
        </div>
        <hr class="">
        <div class="p-5">
            <form class="form-group formContent" method="post" action="post">
                <label class="m-2" for="destinataire">Contacts</label><br>
                <select class="form-control rounded-4 shadow-sm" name="destinataire" id="destinataire">
                    <option value="" class="text-gray">Sélectionner un contact</option>
                    <option value="tous">Tous</option>
                    <?php foreach ($users as $dest) { ?>
                    <option value="<?= $dest['id'] ?>"><?= $dest['pseudo'] ?></option>
                    <?php } ?>
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