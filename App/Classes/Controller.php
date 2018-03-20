<?php
namespace Escuchable\App;

use Stolz\Assets\Manager\Assets;

class Controller extends App
{
    public function __construct() {
        self::addAssets();
    }

    public static function addAssets()
    {
        self::$assets->add(PUBLIC_FOLDER . 'css/font-awesome.css');
        self::$assets->add(PUBLIC_FOLDER . 'css/normalize.css');
        self::$assets->add(PUBLIC_FOLDER . 'css/estilos.css');
        //self::$assets->add(PUBLIC_FOLDER . 'css/simple-grid.min.css');
        self::$assets->add(PUBLIC_FOLDER . 'css/forms.css');
        self::$assets->add(PUBLIC_FOLDER . 'css/toastr.css');
        self::$assets->add(PUBLIC_FOLDER . 'fonts/stylesheet.css');
        //self::$assets->add(PUBLIC_FOLDER . 'css/sweetalert.css');
        //self::$assets->add(PUBLIC_FOLDER . 'css/https://fonts.googleapis.com/css?family=Roboto:400,400i,500,700');

        self::$assets->add(PUBLIC_FOLDER . 'js/jquery-3.3.1.js');
        //self::$assets->add(PUBLIC_FOLDER . 'js/toastr.min.js');
        //self::$assets->add(PUBLIC_FOLDER . 'js/sweetalert.js');
        self::$assets->add(PUBLIC_FOLDER . 'js/functions.js');
    }
}
