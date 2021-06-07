<h1>Votre compte</h1>

<table class="profiletable">
    <tr>
        <td>Photo de profil</td>
        <td> <img src="./img/avatar/<?= htmlspecialchars($user->profilePic); ?>" alt="Photo de profil" class="avatar"></td>
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

<div class="account-creation">
    <h2>Mes commentaires :</h2>
    <table>
        <tr>
            <th>Commentaire</th>
            <th>Article</th>
            <th>Statut</th>
            <th>Supprimer</th>
        </tr>
        <?php foreach ($comments as $comment) : ?>
            <tr>
                <td><?= htmlspecialchars($comment->content); ?></td>
                <td><?= htmlspecialchars($comment->post); ?></td>
                <td><span class="tag tag-<?= $commentStatus[$comment->status]; ?>"><?= COMMENT_STATUS[$comment->status]; ?></span></td>
                <td>
                    <form action='?p=blog.deleteComment' method="post" style="display: inline;">
                        <button class="material-icons danger">
                            clear
                        </button>
                        <?= $form->input('id', null, ['type' => 'hidden', 'value' => $comment->id]); ?>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>

    </table>
</div>