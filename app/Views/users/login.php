<section class='account-creation'>
    <h1>Connexion</h1>
    <form action="#" method="post">
        <?= htmlspecialchars($form->input('username', 'Nom d\'utilisateur', ['required' => 'required', 'autocomplete' => 'current-password'])); ?>
        <br>
        <?= htmlspecialchars($form->input('password', 'Mot de passe', ['type' => 'password', 'required' => 'required', 'autocomplete' => 'current-password'])); ?>
        <br>
        <div class="main-btn"> <?= htmlspecialchars($form->submit(" Se connecter ")); ?> </div>
    </form>
    <div class="center"><a href="?p=users.recover">Mot de passe oublié ?</a></div>

</section>