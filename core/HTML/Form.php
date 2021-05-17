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

    public function input(string $name, ?string $label, array $options = [])
    {
        $type = isset($options['type']) ? $options['type'] : 'text';
        $value = isset($options['value']) ? $options['value'] : $this->getValue($name);
        $label = isset($label) ? $label . ' : <br>' : '';
        return $this->surround($label . ' <input type="' . $type . '" name="' . $name . '" value="' . htmlspecialchars($value) . '">');
    }

    public function submit($label)
    {
        return $this->surround('<input type="submit" value="' . $label . '">');
    }
}
