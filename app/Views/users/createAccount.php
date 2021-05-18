<section class='account-creation'>
    <h1>Créer un compte</h1>
    <?php

    if ($errorMessage) : ?>
        <div class="alert alert-danger">
            <b>Erreur(s) :</b><?= $errorMessage; ?>
            <br>
        </div>
    <?php endif; ?>
    <?php if ($successMessage) : ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($successMessage); ?>
            <br>
        </div>
    <?php endif; ?>
    <form action="#" method="post">
        <?= $form->input('token', null, ['type' => 'hidden', 'value' => $token]); ?>
        <?= $form->input('name', 'Nom d\'utilisateur'); ?>
        <br>
        <?= $form->input('email', 'Email', ['type' => 'email']); ?>
        <br>
        <?= $form->input('password', 'Mot de passe', ['type' => 'password']); ?>
        <br>
        <?= $form->input('confirm_password', 'Confirmer le mot de passe', ['type' => 'password']); ?>
        <br>
        <span class="envoi"> <?= $form->submit(" S’inscrire "); ?> </span>


    </form>

</section>