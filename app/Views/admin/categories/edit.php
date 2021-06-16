<h1>Edition d'une catégorie</h1>

<form action="#" method="POST">
    <section class="post-edition">
        <div class="grid-left">
            <?= $form->input('title', 'Titre de la catégorie'); ?>
        </div>

        <div class="grid-right">
            <?= $form->submit('Enregistrer'); ?>
        </div>
    </section>
</form>