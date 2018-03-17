<?php
namespace Escuchable\App;

class Controller extends App
{
    public function __construct() {
        self::addAssets();
    }

    public static function addAssets()
    {
        Assets::addCss('font-awesome.css');
        Assets::addCss('normalize.css');
        Assets::addCss('estilos.css');
        Assets::addCss('simple-grid.min.css');
        Assets::addCss('forms.css');
        Assets::addCss('toastr.css');
        Assets::addCss('sweetalert.css');
        Assets::addCss('https://fonts.googleapis.com/css?family=Roboto:400,400i,500,700');

        Assets::addJS('jquery-3.3.1.js');
        Assets::addJS('toastr.min.js');
        Assets::addJS('sweetalert.js');
        Assets::addJS('functions.js');
    }
}
