<section class="blog-post">

    <article class="blogpost">
        <h1><?= $post->title; ?></h1>
        <p class="center"><em>Dans <?= $post->category; ?></em></p>
        <p class="center"><em>Par <?= $post->author; ?> - Mise à jour le : <?= $date ?> à <?= $heure; ?></em></p>
        <p><?= $post->chapo; ?>
        </p>
        <br><br><br>
        <p><?= $post->content; ?></p>

    </article>
    <h2>Commentaires :</h2>
    <?php
    if (empty($comments)) { ?>
        <img src="../public/img/site/comments.svg" alt="pas de commentaires">
        <br> <br>
        <p>Aucun commentaire pour le moment, n'hésitez pas à lancer la discution</p>
        <?php } else {
        foreach ($comments as $comment) : ?>
            <div class="comment">
                <div><img src="../public/img/avatar/<?= $comment->authorpic; ?>" class="avatar-comment" alt="Photo de profil"></div>
                <div>
                    <p>De : <b><?= $comment->author; ?></b> Posté le : <em><?= date('d/m/y', strtotime($comment->date)); ?></em></p>
                    <p><?= $comment->content; ?></p>
                </div>


            </div>
    <?php endforeach;
    } ?>


    <h2>Laisser un commentaire :</h2>
    <?php
    if ($session->get('auth') != null) {
    ?>
        <form action="?p=blog.addcomment" method="POST">
            <?= $form->input('post', null, ['type' => 'hidden', 'value' => $post->id]); ?>
            <?= $form->input('content', null, ['type' => 'textarea', 'rows' => 10]); ?>
            <?= $form->submit('Envoyer le commentaire'); ?>
        </form>
    <?php
    } else {
    ?>
        <p>Vous devez être connecté pour laisser un commentaire : </p><br>
        <h3><a href="?p=users.login">Connexion</a></h3>

    <?php } ?>



</section>