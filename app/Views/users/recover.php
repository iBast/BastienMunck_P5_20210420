<section class='account-creation'>
    <h1>Mot de passe oublié ?</h1>
    <form action="#" method="post">
        <?= $form->input('email', 'Votre email', ['required' => 'required', 'type' => 'email']); ?>
        <br>
        <br>
        <div class="main-btn"> <?= $form->submit("Réinitialiser mon mot de passe"); ?> </div>
    </form>


</section>