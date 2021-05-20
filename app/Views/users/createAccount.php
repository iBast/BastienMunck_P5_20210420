<section class='account-creation'>
    <h1>Créer un compte</h1>
    <form action="#" method="post">
        <?= $form->input('name', 'Nom d\'utilisateur'); ?>
        <br>
        <?= $form->input('email', 'Email', ['type' => 'email']); ?>
        <br>
        <?= $form->input('password', 'Mot de passe', ['type' => 'password']); ?>
        <br>
        <?= $form->input('confirm_password', 'Confirmer le mot de passe', ['type' => 'password']); ?>
        <br>
        <div class="main-btn"> <?= $form->submit(" S’inscrire "); ?> </div>


    </form>

</section>