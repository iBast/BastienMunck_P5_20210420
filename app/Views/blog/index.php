<section class="blog-section">
    <h1>Blog</h1>
    <div class="account-creation center">

        <p><b>Catégories :</b> <?php foreach ($categories as $categorie) : ?>
                <a href="<?= $categorie->url; ?>"><?= htmlspecialchars($categorie->title); ?></a> -
            <?php endforeach; ?>
            <a href="?p=blog.index">Toutes</a>
        </p>
    </div>
    <div class="articles">
        <?php foreach ($posts as $post) : ?>
            <a href="<?= $post->url; ?>" class="article">
                <article>
                    <h2><?= htmlspecialchars($post->title) ?></h2>
                    <em>Dans : <?= htmlspecialchars($post->category); ?></em><br>
                    <em>Denière modification :
                        le <?= date("d/m/y", strtotime($post->lastUpdate)); ?>
                        à <?= date("H:i", strtotime($post->lastUpdate)) ?>
                    </em> <br>
                    <br>
                    <p><?= htmlspecialchars($post->chapo) ?>
                    </p>
                </article>
            </a>
        <?php endforeach; ?>
    </div>
    <?= $printCommands ?>
</section>