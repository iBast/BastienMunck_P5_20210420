<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/xhtml" prefix="og: http://ogp.me/ns#">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#FFFCFA">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#FFFCFA">
    <meta property="og:title" content="Bastien Munck - Développeur PHP">
    <meta property="og:description" content="Découvrez mes réalisations, mon actualité et venez échanger avec moi !">
    <meta property="og:url" content="https://bastienmunck.fr">
    <meta property="og:image" content="https://bastienmunck.fr/img/logo.png">
    <meta property="og:site_name" content="Bastien Munck - Développeur PHP">
    <link rel="stylesheet" href="css/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon/favicon-16x16.png">
    <link rel="icon" href="img/favicon/favicon.ico" type="image/x-icon">
    <link rel="manifest" href="/site.webmanifest">
    <title><?= App\App::getInstance()->title; ?></title>
</head>

<body>
    <header>
        <div id="logo">
            <a href="index.php">Bastien Munck <br><span class="Ligne-2">Développeur PHP</span></a>
        </div>
        <input type="checkbox" id="menu-checkbox" />
        <label class="menu-bouton" for="menu-checkbox"><svg viewBox="0 0 100 80" width="40" height="80">
                <rect width="100" height="14" rx="8" fill="#FFBD66"></rect>
                <rect y="30" width="100" height="14" rx="8" fill="#FFBD66"></rect>
                <rect y="60" width="100" height="14" rx="8" fill="#FFBD66"></rect>
            </svg></label>
        <nav class="menu">
            <ul>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="index.php#contact" class="bouton">Contactez-moi</a></li>
            </ul>
        </nav>
    </header>
    <div class="container">
        <?php
        if ($this->session->get('flash') != null) {
        ?>

            <div class="flashMessages">
                <?php
                if ($this->flash->get('danger')) : ?>
                    <div class="alert alert-danger">
                        <b>Erreur(s) :</b> <?= $this->flash->get('danger'); ?>
                        <br>
                    </div>
                <?php endif;
                if ($this->flash->get('success')) : ?>
                    <div class="alert alert-success">
                        <?= $this->flash->get('success'); ?>
                        <br>
                    </div>
                <?php endif;
                if ($this->flash->get('warning')) : ?>
                    <div class="alert alert-warning">
                        <?= $this->flash->get('warning'); ?>
                        <br>
                    </div>
                <?php endif;
                if ($this->flash->get('info')) : ?>
                    <div class="alert alert-info">
                        <?= $this->flash->get('info'); ?>
                        <br>
                    </div>
            <?php endif;
            } ?>
            </div>
            <?= $content; ?>
    </div>
    <footer>
        <details open>
            <summary>Menu</summary>
            <ul>
                <li><a href="blog.html">Blog</a></li>
                <li><a href="blog.html">Inscription / connexion</a></li>
                <li><a href="#contact">Contactez-moi</a></li>
            </ul>
        </details>
        <details open>
            <summary>Mentions légales</summary>
            <ul>
                <li><a href="blog.html">Mentions légales</a></li>
                <li><a href="blog.html">Politique de confidentilité</a></li>
                <li><a href="index.html#contact">Gestion des données personneles</a></li>
            </ul>
        </details>
        <details open>
            <summary>Mon compte</summary>
            <a href="?p=users.signup">Inscription</a>
            <a href="?p=users.login">Connexion</a>
            <a href="?p=users.logout">Déconnexion</a>
            <a href="?p=users.account">Mon compte</a>
            <a href="admin.html">Administration</a>
        </details>
    </footer>

</body>

</html>