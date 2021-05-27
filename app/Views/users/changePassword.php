<section class='account-creation'>
    <h1>Réinitialisation du mot de passe</h1>
    <form action="#" method="post">
        <?= $form->input('current-password', 'Mot de passe actuel', ['required' => 'required', 'type' => 'password']); ?>
        <br>
        <br>
        <br>
        <br>
        <?= $form->input('password', 'Nouveau mot de passe', ['required' => 'required', 'type' => 'password']); ?>
        <br>
        <?= $form->input('passwordConfirm', 'Confirmation du mot de passe', ['required' => 'required', 'type' => 'password']); ?>
        <br>
        <br>
        <div class="main-btn"> <?= $form->submit("Réinitialiser mon mot de passe"); ?> </div>
    </form>


</section>