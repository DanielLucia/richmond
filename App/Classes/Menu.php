<?php

namespace Escuchable\App;

use Escuchable\App\Utils;
use Escuchable\App\Url;

class Menu extends App
{
    private static $_elementos = array();
    private static $actual = false;

    public static function add($prioridad = 0, $lugares = array(), $texto = '', $id = '#', $icon = false, $class = false)
    {
        if (!empty($lugares)) {
            foreach ($lugares as $lugar) {
                self::$_elementos[$lugar][(int) $prioridad][Utils::slug($texto)] = array(
                    'texto' => $texto,
                    'id' => $id,
                    'url' => $id != '#' ? Url::generate($id) :'',
                    'icon' => $icon,
                    'class' => $class,
                );
            }
        }

    }
    public static function get()
    {
        $salida = array();
        foreach (self::$_elementos as $lugar => $elemento) {
            ksort($elemento);
            foreach ($elemento as $posicion => $item) {
                foreach ($item as $subitem) {
                    $subitem['class'] =  $subitem['id'] == self::$actual && self::$actual ? 'Selected' : '';

                    $hook = $lugar . ".menu." . $subitem['id'];
                    $subitem['texto'] = self::$hooks->filter->apply($hook, $subitem['texto']);
                    $salida[$lugar][] = $subitem;
                }
            }
        }
        return $salida;
    }

    public static function setActual($actual) {
        self::$actual = $actual;
    }
}
