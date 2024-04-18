<?php
ob_start();
//var_dump($user_data);
?>

<div>
    <form method="post" action="index.php?profil" class="custom-form d-block ">

        <div class="form-group w-25">
            <label for="email">Adresse email</label>
            <input type="email" name="email" value="<?= $user_data['email'] ?>" id="email" class="form-control" />
        </div>

        <label for="userId"></label>
        <input type="hidden" name="userId" value="<?= $user_data['id'] ?>" id="userId" class="form-control" />

        <div class="form-group w-25">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" placeholder="Changer votre mot de passe" id="password" class="form-control" />
        </div>

        <div class="form-group w-25">
            <label for="password_confirm">Confirmez votre mot de passe</label>
            <input type="password" name="password_confirm" id="password_confirm" placeholder="Confirmer mot de passe" class="form-control" />
        </div>
        <div class="form-group w-50">
            <div class="row">
                <div class="col-md-6">
                    <input type="submit" data-bs-toggle="modal" data-bs-target="#modalPassword" class="btn btn-block bg-red" name="modProfil" id="modProfil" value="Modifier mon compte">
                </div>
            </div>
        </div>
        <div class="form-group w-50">
            <div class="row">
                <div class="col-md-6">
                    <input type="submit" class="btn btn-block bg-red" name="deleteAccount" id="deleteAccount" value="Supprimer mon compte">
                </div>
            </div>
        </div>
    </form>
    <div class="modal fade" id="modalPassword" tabindex="-1" aria-labelledby="modifications" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifications">Voulez-vous confirmer vos modifications ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="index.php?profil">
                        <label for="actualPassword">Mot de passe actuel : </label><br>
                        <input type="password" id="actualPassword" name="actualPassword" placeholder="Mot de passe ...">
                        <input type="submit" id="actualPasswordConfirmation" name="actualPasswordConfirmation" value="Confirmer">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('dashboard.php'); ?>

