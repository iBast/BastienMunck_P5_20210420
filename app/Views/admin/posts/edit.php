<h1>Edition d'un article</h1>

<section class="post-edition">

    <div class="grid-left">
        <?= $form->input('title', 'Titre de \'article'); ?>
        <br>
        <?= $form->input('content', 'Article', ['type' => 'textarea', 'rows' => 25]); ?>
    </div>

    <div class="grid-right">
        <?= $form->input('chapo', 'Chapô', ['type' => 'textarea', 'rows' => 10]); ?>
        <br>
        <?= $form->select('role', 'Catégorie', USER_ROLE); ?>
        <br>
        <p>En ligne : </p> <br>
        <?= $form->toggle('published'); ?>
        <br><br><br>
        <?= $form->submit('Enregistrer'); ?>
    </div>

</section>