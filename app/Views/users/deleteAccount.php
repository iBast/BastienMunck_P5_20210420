<section class='account-creation'>
    <h1>Suppression du compte</h1>
    <br>
    <br>
    <div class="center alert alert-danger">
        <p>Vous être sur le point de supprimer votre compte.</p>
        <p>Cette action sera définitive et ne pourra être annulée.</p>
        <p>Veuillez remplir le mot de passe pour confirmer la supression.</p>
    </div>
    <form action="#" method="post">

        <?= htmlspecialchars($form->input('password', 'Mot de passe', ['type' => 'password'])); ?>

        <div class="form">

            <?= htmlspecialchars($form->submit('Supprimer définitivement le compte')); ?>

        </div>
    </form>
</section>