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
    <div class="comment">
        <p>De : <b>Auteur</b> Posté le : <em>05/05/2021</em></p>
        <p>turpis egestas. Vivamus aliquam condimentum venenatis. Integer efficitur augue sed eros
            fringilla rhoncus. Curabitur venenatis non quam non sodales
            iaculis dapibus consequat. Aliquam et lacus nibh. Sed sodales viverra accumsan. Mauris ac
            efficitur sapien. Pellentesque habitant morbi tristique senectus et netus et malesuada fames
            ac</p>
    </div>

    <div class="comment">
        <p>De : <b>Auteur</b> Posté le : <em>05/05/2021</em></p>
        <p>turpis egestas. Vivamus aliquam condimentum venenatis. Integer efficitur augue sed eros
            fringilla rhoncus. Curabitur venenatis non quam non sodales
            iaculis dapibus consequat. Aliquam et lacus nibh. Sed sodales viverra accumsan. Mauris ac
            efficitur sapien. Pellentesque habitant morbi tristique senectus et netus et malesuada fames
            ac</p>
    </div>

    <div class="comment">
        <p>De : <b>Auteur</b> Posté le : <em>05/05/2021</em></p>
        <p>turpis egestas. Vivamus aliquam condimentum venenatis. Integer efficitur augue sed eros
            fringilla rhoncus. Curabitur venenatis non quam non sodales
            iaculis dapibus consequat. Aliquam et lacus nibh. Sed sodales viverra accumsan. Mauris ac
            efficitur sapien. Pellentesque habitant morbi tristique senectus et netus et malesuada fames
            ac</p>
    </div>

    <h2>Laisser un commentaire :</h2>
    <p>Vous devez être connecté pour laisser un commentaire : </p><br>
    <h3><a href="login.html">Connexion</a></h3>

    <div class="form-text">
        <label for="message">Votre message : </label><br><br>
        <textarea name="message" id="message" rows="10"></textarea>
    </div>
    <div class="send-comment">
        <input type="submit" value="Envoyer le commentaire">
    </div>



</section>