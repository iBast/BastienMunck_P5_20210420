<h1>Gestion des catégories</h1>

<section class="account-creation">
    <a href="?p=admin.categories.add" class="btn btn-outline">Ajouter une categorie</a>
    <table>
        <tr>
            <th>Titre</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($categories as $category) : ?>
            <tr>
                <td><?= htmlspecialchars($category->title); ?></td>
                <td><a href="?p=admin.categories.edit&id=<?= $category->id; ?>"><span class="material-icons">
                            edit
                        </span></a>
                    <form action='?p=admin.categories.delete' method="post" style="display: inline;">
                        <button class="material-icons danger">
                            clear
                        </button>
                        <?= $form->input('id', null, ['type' => 'hidden', 'value' => $category->id]); ?>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>