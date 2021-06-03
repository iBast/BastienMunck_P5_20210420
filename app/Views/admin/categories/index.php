<h1>Gestion des catégories</h1>

<section class="account-creation">
    <a href="?p=admin.categories.add" class="btn btn-outline">Ajouter une catégorie</a>
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
                    <a href="?p=admin.users.delete&id="><button class="material-icons">
                            clear
                        </button></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>