<?php

namespace Core\HTML;


/**
 * 
 */
class Form
{

    protected $data;
    public $surround = 'p';


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

    public function input(string $name, string $label, array $options = [])
    {
        $type = isset($options['type']) ? $options['type'] : 'text';
        return $this->surround($label . ' : <br> <input type="' . $type . '" name="' . $name . '" value="' . htmlspecialchars($this->getValue($name)) . '">');
    }

    public function submit($label)
    {
        return $this->surround('<input type="submit" value="' . $label . '">');
    }
}
