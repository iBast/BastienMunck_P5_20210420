<section class="blog-post">

    <article class="blogpost">
        <h1><?= htmlspecialchars($post->title); ?></h1>
        <p class="center"><em>Dans <?= htmlspecialchars($post->category); ?></em></p>
        <p class="center"><em>Par <?= htmlspecialchars($post->author); ?> - Mise à jour le : <?= date('d/m/y', strtotime($post->lastUpdate)) ?> à <?= date('H:i', strtotime($post->lastUpdate)) ?></em></p>
        <br><br>
        <p>
        <pre><?= htmlspecialchars($post->chapo); ?></pre>
        </p>
        <br><br><br>
        <p>
        <pre><?= htmlspecialchars($post->content); ?></pre>
        </p>

    </article>
    <h2>Commentaires :</h2>
    <?php
    if (empty($comments)) { ?>
        <img src="./img/site/comments.svg" alt="pas de commentaires">
        <br> <br>
        <p>Aucun commentaire pour le moment, n'hésitez pas à lancer la discution</p>
        <?php } else {
        foreach ($comments as $comment) : ?>
            <div class="comment">
                <div><img src="./img/avatar/<?= $comment->authorpic; ?>" class="avatar-comment" alt="Photo de profil"></div>
                <div>
                    <p>De : <b><?= htmlspecialchars($comment->author) ?></b> Posté le : <em><?= date('d/m/y', strtotime($comment->date)); ?></em></p>
                    <p><?= htmlspecialchars($comment->content) ?></p>
                </div>


            </div>
    <?php endforeach;
    } ?>


    <h2>Laisser un commentaire :</h2>
    <?php
    if ($session->get('auth') != null) {
        if ($session->get('role') != 0) {
    ?>
            <form action="?p=blog.addcomment" method="POST">
                <?= $form->input('post', null, ['type' => 'hidden', 'value' => $post->id]); ?>
                <?= $form->input('content', null, ['type' => 'textarea', 'rows' => 10]); ?>
                <?= $form->submit('Envoyer le commentaire'); ?>
            </form>
        <?php
        } else {
        ?>
            <p>Votre compte est toujours en attente de validation <br> <a href="?p=users.resendmail">Cliquez ici pour renvoyer le mail d'activation</a></p>
        <?php
        }
    } else {
        ?>
        <p>Vous devez être connecté pour laisser un commentaire : </p><br>
        <h3><a href="?p=users.login">Connexion</a></h3>

    <?php } ?>



</section>