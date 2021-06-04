<h1>Edition d'un article</h1>

<form action="#" method="POST">
    <section class="post-edition">
        <div class="grid-left">
            <?= $form->input('title', 'Titre de \'article'); ?>
            <br>
            <?= $form->input('content', 'Article', ['type' => 'textarea', 'rows' => 25]); ?>
        </div>

        <div class="grid-right">
            <?= $form->input('chapo', 'Chapô', ['type' => 'textarea', 'rows' => 10]); ?>
            <br>
            <?= $form->select('category', 'Catégorie', $categories); ?>
            <br>
            <?= $form->toggle('published', 'En ligne :', $checked); ?>
            <br><br><br>
            <p class="center"><?= $form->submit('Enregistrer'); ?></p>
        </div>
    </section>
</form>