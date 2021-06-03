<h1>Gestion des articles</h1>

<section class="account-creation">
    <a href="?p=admin.posts.add" class="btn btn-outline">Ajouter un article</a>
    <table>
        <tr>
            <th>Titre</th>
            <th>Categorie</th>
            <th>Auteur</th>
            <th>Statut</th>
            <th>Dernière modification</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($posts as $post) : ?>
            <tr>
                <td><?= htmlspecialchars($post->title); ?></td>
                <td><?= htmlspecialchars($post->category); ?></td>
                <td><?= htmlspecialchars($post->author); ?></td>
                <td><?= POST_STATUS[(htmlspecialchars($post->published))]; ?></td>
                <td><?= htmlspecialchars($post->lastUpdate); ?></td>
                <td><a href="?p=admin.posts.edit&id=<?= $post->id; ?>"><span class="material-icons">
                            edit
                        </span></a>
                    <form action='?p=admin.posts.delete' method="post" style="display: inline;">
                        <button class="material-icons danger">
                            clear
                        </button>
                        <?= $form->input('id', null, ['type' => 'hidden', 'value' => $post->id]); ?>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>