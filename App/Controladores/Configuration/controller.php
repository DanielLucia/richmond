<?php

use Escuchable\App\Utils as Utils;
use Escuchable\App\Controller;
use Escuchable\App\Menu;
use Escuchable\App\Url;

use Escuchable\Modelos\Widgets;

class configurationController extends Controller
{
    public function __construct()
    {
        Menu::add(2, array('sidebar'), 'Configuración', 'configuration', 'sliders');

        Menu::add(2, array('configuracion'), 'Configuración', 'configuration');
        Menu::add(2, array('configuracion'), 'Usuarios', 'usuarios');
        Menu::add(2, array('configuracion'), 'Grupos', 'grupos');
        Menu::add(2, array('configuracion'), 'Widgets', 'widgets');
    }
    public static function index()
    {
        self::addAssets();

        $title = 'Configuración';
        $data = array(
            'title' => $title,
        );

        self::$view->assign($data);
        self::$view->render('index');

    }

    public static function usuarios()
    {
        self::addAssets();

        $title = 'Usuarios';
        $data = array(
            'title' => $title,
        );

        self::$view->assign($data);
        self::$view->render('index');

    }

    public static function grupos()
    {
        self::addAssets();

        $title = 'Grupos';
        $data = array(
            'title' => $title,
        );

        self::$view->assign($data);
        self::$view->render('index');

    }
    public static function widgets()
    {
        self::addAssets();

        $title = 'Widgets';
        $data = array(
            'title' => $title,
            'widgets' => Widgets::all(),
        );

        self::$view->assign($data);
        self::$view->render('widgets');

    }
}
