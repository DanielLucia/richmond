<?php

use Escuchable\App\Utils as Utils;
use Escuchable\App\Controller;
use Escuchable\App\Menu;
use Escuchable\App\Url;

/*use Escuchable\Modelos\Categorias;
use Escuchable\Modelos\Podcast;
use Escuchable\Modelos\Episodios;*/

class indexController extends Controller
{

    public function __construct()
    {
        Menu::add(0, array('sidebar'), 'Principal', 'home', 'home');
        Menu::add(99, array('sidebar'), 'Salir', 'logout', 'sign-out');
    }

    public static function index()
    {
        self::addAssets();

        $title = 'Home';
        $data = array(
            'title' => $title,
            'bodyClass' => 'Categorias',
        );

        self::$view->assign($data);
        self::$view->render('index');

    }

}
