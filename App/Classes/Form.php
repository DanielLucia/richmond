<?php

namespace Escuchable\App;

class Form extends App
{
    public $elements;
    public $action;
    public $method;
    public $class;
    public $output;

    public function __construct($elements, $action, $method = 'POST', $class = '')
    {
        $this->elements = $elements;
        $this->action = $action;
        $this->method = $method;
        $this->class = $class;
    }

    public function dumpElements()
    {
        var_dump($this->elements);
    }

    public function open() {
        $this->output = '<form action="' . $this->action . '" method="'.$this->method.'" class="Form '.$this->class.'">';
        $this->output .= self::$hooks->action->run("form.open");
    }

    public function close() {
        $this->output .= self::$hooks->action->run("form.close", false);
        $this->output .= '</form>';
    }

    public function build()
    {
        $this->open();
        foreach ($this->elements as $name => $elements) {
            $label = '<label>' . $elements['title'] . '</label>';
            switch ($elements['type']) {
                case 'textarea':
                  $input = '<textarea name="' . $name . '"  class="Text ' . $elements['class'] . '"></textarea>';
                  break;
                case 'submit':
                  $input = '<button type="submit" name="' . $name . '" class="Button ' . (isset($elements['class']) ? $elements['class'] : '') . '">' . $elements['title'] . '</button>';
                  $label = '';
                  break;
                default:
                  $input = '<input type="' . $elements['type'] . '" name="' . $name . '"  class="Text ' . (isset($elements['class']) ? $elements['class'] : '') . '" />';
                  break;
              }
            $this->output .= '<p>'.$label . $input . '</p>';
        }

        $this->close();

        return $this->output;
    }
}
