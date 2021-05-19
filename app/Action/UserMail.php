<?php

namespace App\Action;

use Core\Config;
use Core\Mail\Mail;

class UserMail
{

    private $mailerInstance;

    private function getMailer()
    {
        $config = Config::getInstance('././config/config.php');
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

http://localhost:8888/BastienMunck_P5_20210420/public/?p=users.verifyToken&t=' . $userToken . '&username=' . $userName . '

Nous vous remercions de votre inscription.
A bientôt sur le blog !
        ';

        return $mailerInstance->send('Confirmation d\'inscription', $userEmail, $userName, $message);
    }
}
