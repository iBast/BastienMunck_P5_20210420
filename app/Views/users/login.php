<section class='account-creation'>
    <h1>Connexion</h1>
    <form action="#" method="post">
        <?= $form->input('username', 'Nom d\'utilisateur', ['required' => 'required', 'autocomplete' => 'current-password']); ?>
        <br>
        <?= $form->input('password', 'Mot de passe', ['type' => 'password', 'required' => 'required', 'autocomplete' => 'current-password']); ?>
        <br>
        <div class="main-btn"> <?= $form->submit(" Se connecter "); ?> </div>


    </form>

</section>