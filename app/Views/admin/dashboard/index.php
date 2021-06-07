<section class="blog-section">
    <h1>Administration</h1>
    <div class="articles">
        <a href="?p=admin.comments.index" class="article">
            <article>
                <h2>Commentaires à valider</h2>
                <p> Il y a <b><?= $count['comments']->status; ?> </b> commentaires à valider
                </p>
            </article>
        </a>
        <a href="?p=admin.users.index" class="article">
            <article>
                <h2>Utilisateurs</h2>
                <p>Il y a <?= $count['usertable'][0]->id; ?> utilisateurs</p>
                <p><?= $count['usermail']->role; ?> n'ont pas validé le mail</p>
            </article>
        </a>
        <a href="?p=admin.posts.index" class="article">
            <article>
                <h2>Articles</h2>
                <p>Il y a <?= $count['articlesPublished']->published; ?> articles en ligne</p>
                <p>Il y a <?= $count['articlesPending']->published; ?> articles en brouillons</p>
            </article>
        </a>
        <a href="?p=admin.categories.index" class="article">
            <article>
                <h2>Catégories</h2>
                <p>Il y a <?= $count['categories'][0]->id; ?> catégories</p>
            </article>
        </a>



    </div>



</section>