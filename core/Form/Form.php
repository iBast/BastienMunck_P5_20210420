<?php

namespace Core\Form;

use Core\Http\Session;

/**
 *  Build form
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

    /**
     * surround a string with defined tag
     *
     * @param  string $html
     * @return string
     */
    protected function surround($html): string
    {
        return "<{$this->surround}>{$html}</{$this->surround}>";
    }

    /**
     * getValue return values from an object or an array
     *
     * @param  mixed $index
     * @return mixed
     */
    protected function getValue($index)
    {
        if (is_object($this->data)) {
            return $this->data->$index;
        }
        return isset($this->data[$index]) ? $this->data[$index] : null;
    }

    /**
     * From input 
     *
     * @param  string $name
     * @param  string $label
     * @param  array $options
     * @return string
     */
    public function input(string $name, ?string $label, array $options = [])
    {
        $type = isset($options['type']) ? $options['type'] : 'text';
        $autocomplete = isset($options['autocomplete']) ? 'autocomplete="' . $options['autocomplete'] . '"' : '';
        $required = isset($options['required']) ? $options['required'] : '';
        $accept = isset($options['accept']) ? 'accept="' . $options['accept'] . '"' : '';
        $value = isset($options['value']) ? $options['value'] : $this->getValue($name);
        $label = isset($label) ? $label . ' : <br>' : '';
        $rows = isset($options['rows']) ? 'rows="' . $options['rows'] . '"' : '';
        if ($type === 'textarea') {
            $input = '<textarea name="' . $name . '" ' . $rows . '>' . htmlspecialchars($value) . '</textarea>';
        } else {
            $input = ' <input type="' . $type . '" name="' . $name . '" value="' . htmlspecialchars($value) . '" ' . $autocomplete . $required . $accept . '>';
        }
        return $this->surround($label . $input);
    }

    /**
     * From select
     *
     * @param  string $name
     * @param  string $label
     * @param  array $options
     * @return string
     */
    public function select(string $name, ?string $label, array $options)
    {
        $label = isset($label) ?  '<label>' . $label . ' : </label> <br>' : '';
        $input = '<select  name=' . $name . '>';
        foreach ($options as $key => $value) {
            $attributes = '';
            if ($key == $this->getValue($name)) {
                $attributes = 'selected';
            }
            $input .= "<option value='$key' $attributes>$value</option>";
        }
        $input .= '</select>';
        return $this->surround($label . $input);
    }

    /**
     * toggle : checkbox 
     *
     * @param  string $name
     * @param  string $label
     * @param  bool $checked
     * @return string
     */
    public function toggle($name, $label, ?string $checked)
    {
        $checked = isset($checked) ? $checked : '';
        $input = '<div class="toggle"><div class="grid-left">' . $label . '</div>
            <div class="grid-right-monorow"><label class="switch">   
            <input type="hidden" name="' . $name . '" value="0"> 
            <input type="checkbox" name="' . $name . '" value="1" ' . $checked . '>
            <span class="slider round"></span>
            </label></div></div>';
        return $this->surround($input);
    }

    /**
     * submit a form 
     * 
     * has hidden inputs, use token for form validation through the class FormCheck
     *
     * @param  string $label
     * @return string
     */
    public function submit(string $label)
    {
        $this->newToken();
        $submit = $this->input('tokenName', null, ['type' => 'hidden', 'value' => $this->tokenName]);
        $submit .= $this->input('token', null, ['type' => 'hidden', 'value' => $this->token]);
        $submit .= '<br>';
        $submit .= $this->input('submit', null, ['type' => 'submit', 'value' => $label]);
        return $submit;
    }

    /**
     * newToken generate token
     *
     * @return void
     */
    private function newToken()
    {
        $this->token = bin2hex(random_bytes(16));
        $this->tokenName = uniqid('token-');
        $session = new Session;
        $session->set($this->tokenName, $this->token);
    }
}
