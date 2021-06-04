<section class='account-creation'>
    <h1>Connexion</h1>
    <br>
    <p class="center">Pas encore de compte ? <a href="?p=users.signup">Créer un compte</a></p>
    <form action="#" method="post">
        <?= $form->input('username', 'Nom d\'utilisateur', ['required' => 'required', 'autocomplete' => 'current-password']); ?>
        <br>
        <?= $form->input('password', 'Mot de passe', ['type' => 'password', 'required' => 'required', 'autocomplete' => 'current-password']); ?>
        <br>
        <div class="main-btn"> <?= $form->submit(" Se connecter "); ?> </div>
    </form>
    <div class="center"><a href="?p=users.recover">Mot de passe oublié ?</a></div>

</section>