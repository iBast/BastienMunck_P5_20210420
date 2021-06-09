<?php

namespace App\Action;

use Core\Config;
use Core\Mail\Mail;

/**
 * UserMail
 * 
 * configuration for the email sent
 */
class UserMail
{

    private $mailerInstance;

    private function getMailer()
    {
        $config = Config::getInstance(ROOT . '/config/config.php');
        if ($this->mailerInstance === null) {
            $this->mailerInstance = new Mail(
                $config->get('smtp_username'),
                $config->get('smtp_pass'),
                $config->get('smtp_mail'),
                $config->get('smtp_alias'),
                $config->get('smtp_server'),
                $config->get('smtp_port'),
                $config->get('smtp_encrypt')
            );
        }
        return $this->mailerInstance;
    }

    public function signupMail($userEmail, $userName, $userToken)
    {
        $mailerInstance = $this->getMailer();

        $message =
            'Bonjour ' . $userName . '


Vous venez de vous inscrire sur notre blog. Afin de pouvoir profiter d\'encore plus de fonctionnalités 
veuillez confirmer votre adresse email en suivant le lien ci-dessous : 

' . SITE_URL . '/?p=users.verifyToken&t=' . $userToken . '&username=' . $userName . '

Nous vous remercions de votre inscription.
A bientôt sur le blog !
        ';

        return $mailerInstance->send('Confirmation d\'inscription', $userEmail, $userName, $message);
    }

    public function recoverMail($userEmail, $userName, $newPassword)
    {
        $mailerInstance = $this->getMailer();

        $message =
            'Bonjour ' . $userName . ',


Vous avez demandé la réinitalisation de votre mot de passe. Votre nouveau mot de passe est : 

 ' . $newPassword .  '

Il vous sera demandé de modifier ce mot de passe lors de la prochaine connexion.

A bientôt sur le blog !
        ';

        return $mailerInstance->send('Réinitialisation du mot de passe', $userEmail, $userName, $message);
    }

    public function contactMail($userEmail, $userName, $message)
    {
        $mailerInstance = $this->getMailer();

        $message =
            'Bonjour,
        
Un nouveau message a été envoyé depuis la page d\'accueil du site https://bastienmunck.fr :

Le message a été envoyé par ' . $userName . ', ' . $userEmail . '

Voici le contenu : 

' . $message . ' 
        ';

        return $mailerInstance->send('Un message a été envoyé depuis bastienmunck.fr', 'hello@bastienmunck.fr', 'Formulaire de contact', $message);
    }
}
