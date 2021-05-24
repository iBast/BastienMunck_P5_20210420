<?php

namespace Core\Form;

use Core\Http\Session;

/**
 * 
 */
class Form
{

    protected $data;
    public $surround = 'p';
    private $token;


    public function __construct($data = array())
    {
        $this->data = $data;
    }

    protected function surround($html)
    {
        return "<{$this->surround}>{$html}</{$this->surround}>";
    }

    protected function getValue($index)
    {
        if (is_object($this->data)) {
            return $this->data->$index;
        }
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

    public function input(string $name, ?string $label, array $options = [])
    {
        $type = isset($options['type']) ? $options['type'] : 'text';
        $autocomplete = isset($options['autocomplete']) ? 'autocomplete="' . $options['autocomplete'] . '"' : '';
        $required = isset($options['required']) ? $options['required'] : '';
        $value = isset($options['value']) ? $options['value'] : $this->getValue($name);
        $label = isset($label) ? $label . ' : <br>' : '';
        return $this->surround($label . ' <input type="' . $type . '" name="' . $name . '" value="' . htmlspecialchars($value) . '" ' . $autocomplete . $required . '>');
    }

    public function submit($label)
    {
        $this->newToken();
        $submit = $this->input('token', null, ['type' => 'hidden', 'value' => $this->token]);
        $submit .= '<br>';
        $submit .= $this->input('submit', null, ['type' => 'submit', 'value' => $label]);
        return $submit;
    }

    private function newToken()
    {
        $this->token = bin2hex(random_bytes(16));
        $session = new Session;
        $session->set('token', $this->token);
    }
}
