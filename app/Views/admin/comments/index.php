<h1>Gestion des commentaires</h1>

<section class="account-creation">
    <a href="?p=admin.posts.add" class="btn btn-outline">Ajouter un article</a>
    <table>
        <tr>
            <th>Auteur</th>
            <th>Commentaire</th>
            <th>Article</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($comments as $comment) : ?>
            <tr>
                <td><?= htmlspecialchars($comment->author); ?></td>
                <td><?= htmlspecialchars($comment->content); ?></td>
                <td><a href="?p=blog.show&id=<?= $comment->postid; ?>"><?= htmlspecialchars($comment->post); ?></a></td>
                <td><a href="?p=admin.comments.validate&id=<?= $comment->id; ?>"><span class="material-icons">
                            thumb_up
                        </span></a>
                    <a href="?p=admin.comments.reject&id=<?= $comment->id; ?>"><span class="material-icons">
                            thumb_down
                        </span></a>
                    <form action='?p=admin.comments.delete' method="post" style="display: inline;">
                        <button class="material-icons danger">
                            clear
                        </button>
                        <?= $form->input('id', null, ['type' => 'hidden', 'value' => $comment->id]); ?>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>