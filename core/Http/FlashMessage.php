<?php

namespace Core\Http;

/**
 * FlashMessage 
 * 
 * Pass an information message which been shown one time to the user
 */
class FlashMessage
{

    private $session;
    private $sessionKey = 'flash';
    private $messages;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function success(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['success'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    public function danger(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['danger'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    public function warning(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['warning'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }
    public function info(string $message)
    {
        $flash = $this->session->get($this->sessionKey, []);
        $flash['info'] = $message;
        $this->session->set($this->sessionKey, $flash);
    }

    public function get(string $type)
    {
        if ($this->messages === null) {
            $this->messages = $this->session->get($this->sessionKey, []);
            $this->session->delete($this->sessionKey);
        }
        if (array_key_exists($type, $this->messages)) {
            return $this->messages[$type];
        }
        return null;
    }
}
