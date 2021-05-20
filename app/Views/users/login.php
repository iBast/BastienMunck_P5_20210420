<section class='account-creation'>
    <h1>Connexion</h1>
    <form action="#" method="post">
        <?= $form->input('name', 'Nom d\'utilisateur'); ?>
        <br>
        <?= $form->input('password', 'Mot de passe', ['type' => 'password']); ?>
        <br>
        <div class="main-btn"> <?= $form->submit(" Se connecter "); ?> </div>


    </form>

</section>