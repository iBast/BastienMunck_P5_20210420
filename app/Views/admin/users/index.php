<h1>Gestion des utilisateurs</h1>

<section class='account-creation'>
    <table>
        <tr>
            <th>Nom</th>
            <th>Validation mail</th>
            <th>Role</th>
            <th>Modifer</th>
        </tr>
        <?php foreach ($users as $user) : ?>
            <tr>
                <td><?= htmlspecialchars($user->username); ?></td>
                <td><?php if ($user->verifiedAt != null) { ?>
                        <span class="tag tag-valid">Validé</span>
                    <?php } else { ?>
                        <span class="tag tag-warning">En attente</span>
                    <?php } ?>
                </td>
                <td><?= USER_ROLE[$user->role]; ?></td>
                <td><a href="?p=admin.users.edit&id=<?= htmlspecialchars($user->id); ?>"><span class="material-icons">
                            edit
                        </span></a></td>
            </tr>
        <?php endforeach; ?>

    </table>
</section>