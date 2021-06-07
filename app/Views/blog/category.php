<section class="blog-section">
    <h1>Blog : <?= $category->title; ?></h1>
    <div class="account-creation center">

        <p><b>Catégories :</b> <?php foreach ($categories as $categorie) : ?>
                <a href="<?= $categorie->url; ?>"><?= $categorie->title; ?></a> -
            <?php endforeach; ?>
        </p>
    </div>
    <div class="articles">
        <?php foreach ($posts as $post) : ?>
            <a href="<?= $post->url; ?>" class="article">
                <article>
                    <h2><?= $post->title; ?></h2>
                    <em>Dans : <?= $post->category; ?></em><br>
                    <em>Denière modification :
                        <?php $time = strtotime($post->lastUpdate);
                        $date = date("d/m/y", $time);
                        $heure = date("H:i", $time)
                        ?>
                        le <?= $date; ?> à <?= $heure; ?>
                    </em> <br>
                    <br>
                    <p><?= $post->chapo; ?>
                    </p>
                </article>
            </a>
        <?php endforeach; ?>
    </div>
</section>