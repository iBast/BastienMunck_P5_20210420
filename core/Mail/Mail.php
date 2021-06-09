<?php

namespace Core\Mail;

use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

/**
 * Mail 
 * 
 * use to send mail, configuration is in App/cinfig/config.php
 */
class Mail
{
    private $smtp_username;
    private $smtp_pass;
    private $smtp_mail;
    private $smtp_alias;
    private $smtp_server;
    private $smtp_port;
    private $smtp_encrypt;

    public function __construct($smtp_username, $smtp_pass, $smtp_mail, $smtp_alias, $smtp_server, $smtp_port, $smtp_encrypt = null)
    {
        $this->smtp_username = $smtp_username;
        $this->smtp_pass = $smtp_pass;
        $this->smtp_mail = $smtp_mail;
        $this->smtp_alias = $smtp_alias;
        $this->smtp_server = $smtp_server;
        $this->smtp_port = $smtp_port;
        $this->smtp_encrypt = $smtp_encrypt;
    }


    public function send($object, $sendToEmail, $sendToName, $content)
    {
        $transport = new Swift_SmtpTransport($this->smtp_server, $this->smtp_port, $this->smtp_encrypt);
        $transport->setUsername($this->smtp_username)->setPassword($this->smtp_pass);
        $mailer = new Swift_Mailer($transport);
        $message = new Swift_Message($object);
        $message->setFrom([$this->smtp_mail => $this->smtp_alias])
            ->setTo([$sendToEmail => $sendToName])
            ->setBody($content);
        return $mailer->send($message);
    }
}
