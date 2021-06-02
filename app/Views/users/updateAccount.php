<h1>Votre compte</h1>
<form action="#" method="post" enctype="multipart/form-data">
    <table class="profiletable">
        <tr>
            <td>Photo de profil</td>
            <td> <img src="../public/img/avatar/<?= htmlspecialchars($user->profilePic); ?>" alt="Photo de profil" height="100px"></td>
        </tr>
        <tr>
            <td>Nouvelle photo de profil</td>
            <td> <?= $form->input('profilePic', null, ['type' => 'file', 'accept' => 'image/jpeg, image/jpg']); ?></td>
        </tr>
        <tr>
            <td>Nom d'utilisateur</td>
            <td><?= htmlspecialchars($user->username); ?></td>
        </tr>
        <tr>
            <td>Nouveau nom d'utilisateur</td>
            <td><?= $form->input('username', null); ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?= htmlspecialchars($user->email); ?></td>
        </tr>
        <tr>
            <td>Nouvelle adresse Email</td>
            <td><?= $form->input('email', null, ['type' => 'email']); ?></td>
        </tr>
    </table>
    <br>
    <div class="form">
        <a href="?p=users.deleteAccount">
            <div class="btn btn-outline-danger">Supprimer le compte</div>
        </a>
        <?= $form->submit('Enregistrer les modifications'); ?>
    </div>
</form>