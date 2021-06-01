<section class='account-creation'>
    <h1>Créer un compte</h1>
    <form action="#" method="post">
        <?= htmlspecialchars($form->input('username', 'Nom d\'utilisateur')); ?>
        <br>
        <?= htmlspecialchars($form->input('email', 'Email', ['type' => 'email'])); ?>
        <br>
        <?= htmlspecialchars($form->input('password', 'Mot de passe', ['type' => 'password'])); ?>
        <br>
        <?= htmlspecialchars($form->input('confirm_password', 'Confirmer le mot de passe', ['type' => 'password'])); ?>
        <br>
        <div class="main-btn"> <?= htmlspecialchars($form->submit(" S’inscrire ")); ?> </div>


    </form>

</section>