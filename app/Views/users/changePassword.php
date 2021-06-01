<section class='account-creation'>
    <h1>Modification du mot de passe</h1>
    <form action="#" method="post">
        <?= htmlspecialchars($form->input('email', 'Votre adresse email', ['required' => 'required', 'type' => 'email'])); ?>
        <br>
        <?= htmlspecialchars($form->input('current-password', 'Mot de passe actuel', ['required' => 'required', 'type' => 'password'])); ?>
        <br>
        <br>
        <br>
        <br>
        <?= htmlspecialchars($form->input('password', 'Nouveau mot de passe', ['required' => 'required', 'type' => 'password'])); ?>
        <br>
        <?= htmlspecialchars($form->input('password-confirm', 'Confirmation du mot de passe', ['required' => 'required', 'type' => 'password'])); ?>
        <br>
        <br>
        <div class="main-btn"> <?= htmlspecialchars($form->submit("Modifier mon mot de passe")); ?> </div>
    </form>
    <div class="center"><a href="?p=users.recover">Mot de passe oublié ?</a></div>

</section>