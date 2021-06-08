<h1>Mise à jour du profil de : <?= htmlspecialchars($user->username); ?></h1>
<form action="#" method="post" enctype="multipart/form-data">
    <table class="profiletable">
        <tr>
            <td>Photo de profil</td>
            <td> <img src="./img/avatar/<?= htmlspecialchars($user->profilePic); ?>" alt="Photo de profil" height="100px"></td>
        </tr>
        <tr>
            <td>Nouvelle photo de profil</td>
            <td> <?= $form->input('profilePic', null, ['type' => 'file', 'accept' => 'image/jpeg, image/jpg']); ?></td>
        </tr>
        <tr>
            <td>Nouveau nom d'utilisateur</td>
            <td><?= $form->input('username', null); ?></td>
        </tr>
        <tr>
            <td>Nouvelle adresse Email</td>
            <td>
                <?= $form->input('email', null, ['type' => 'email']); ?>
            </td>
        </tr>
        <tr>
            <td>Validation de l'adresse email</td>
            <td><?php if ($user->verifiedAt != null) { ?>
                    <span class="tag tag-valid">Validé</span>
                <?php } else { ?>
                    <span class="tag tag-warning">En attente</span>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td>Rôle</td>
            <td>
                <?= $form->select('role', null, USER_ROLE); ?>
            </td>
        </tr>
    </table>
    <br>
    <div class="form">
        <?= $form->submit('Enregistrer les modifications'); ?>
    </div>
</form>
<form action='?p=admin.users.deleteAccount' method="POST" style="display: inline">
    <?= $form->input('userid', null, ['type' => 'hidden', 'value' => $user->id]); ?>
    <button type="submit" class="btn btn-outline-danger">Supprimer le compte</button>
</form>