<section class="hero-section">
    <div class="hero-banner">
        <img src="img/site/hero.svg" alt="image de présentation" />
    </div>
    <div class="main-title">
        <h1>Je vous accompagne dans la réalisation de vos projets <span class="accent">de sites internet et
                d’applications web.</span> </h1>
        <br><br>
        <p>
        </p>
        <br>
        <div class="main-btn">
            <a href="#contact" class="btn btn-main"><span>LANCER VOTRE PROJET</span> </a>
            <a href="blog.html" class="btn btn-outline">VOIR MON BLOG</a>

        </div>
    </div>

</section>
<section class="contact" id="contact">
    <h2>Contactez-moi</h2>
    <form method="POST" action="#">
        <div class="form">

            <div class="form-nom">
                <?= htmlspecialchars($form->input('name', 'Votre nom')); ?>
            </div>


            <div class="form-mail">
                <?= htmlspecialchars($form->input('email', 'Votre adresse email', ['type' => 'email'])); ?>
            </div>


            <div class="form-text">
                <?= htmlspecialchars($form->input('message', 'Votre message', ['type' => 'textarea', 'rows' => 10])); ?>
            </div>
        </div>

        <div class="envoi">
            <div class="main-btn">
                <?= htmlspecialchars($form->submit("Envoyer le message")); ?>
            </div>
            <div class="coordonnees">
                <div class="avatar-class">
                    <img src="img/site/avatar.jpeg" alt="avatar" class="avatar" />
                </div>
                <div class="profil">
                    <p>Bastien Munck <br>
                        <a href="mailto:hello@bastienmunck.fr">hello@bastienmunck.fr</a> <br>
                        06 08 72 41 62 <br><br>
                    </p>
                    <p>
                        <a href="https://twitter.com/_iBast"><img src="img/site/Twitter_Bird.svg" height="32" width="32" alt="twitter" /> |</a>
                        <a href="https://github.com/iBast"><img src="img/site/GitHub-Mark-32px.png" height="32" width="32" alt="twitter" /> |</a>
                        <a href="https://www.linkedin.com/in/bastien-m-334b97137/"><img src="img/site/linkedin-icon.svg" height="32" width="32" alt="twitter" /> </a>
                    </p>
                </div>

            </div>


        </div>

    </form>

</section>