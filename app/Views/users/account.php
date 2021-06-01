<h1>Votre compte</h1>

<table class="profiletable">
    <tr>
        <td>Photo de profil</td>
        <td> <img src="../public/img/avatar/<?= htmlspecialchars($user->profilePic); ?>" alt="Photo de profil" height="100px"></td>
    </tr>
    <tr>
        <td>Nom d'utilisateur</td>
        <td><?= htmlspecialchars($user->username); ?></td>
    </tr>
    <tr>
        <td>Email</td>
        <td><?= htmlspecialchars($user->email); ?></td>
    </tr>
</table>
<div class="form">
    <a href="?p=users.changePassword">
        <div class="btn btn-outline">Modifier le mot de passe</div>
    </a>
    <a href="?p=users.updateAccount">
        <div class="btn btn-outline">Modifier le profil</div>
    </a>
</div>