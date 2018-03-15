<?php

use Escuchable\App\Utils as Utils;
use Escuchable\App\Controller;
use Escuchable\App\Menu;
use Escuchable\App\Url;

/*use Escuchable\Modelos\Categorias;
use Escuchable\Modelos\Podcast;
use Escuchable\Modelos\Episodios;*/

class accountController extends Controller
{

    public function __construct()
    {
        Menu::add(1, array('sidebar'), 'Mi cuenta', 'account', 'user');
    }

    public static function index()
    {
        self::addAssets();

        $title = 'Mi cuenta';
        $data = array(
            'title' => $title,
            'bodyClass' => 'Categorias',
        );

        self::$view->assign($data);
        self::$view->render('index');

    }

}
