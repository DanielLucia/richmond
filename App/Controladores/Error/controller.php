<?php

use Escuchable\App\Utils as Utils;
use Escuchable\App\Controller;
use Escuchable\App\Menu;
use Escuchable\App\Url;

/*use Escuchable\Modelos\Categorias;
use Escuchable\Modelos\Podcast;
use Escuchable\Modelos\Episodios;*/

class errorController extends Controller
{
    public $login = true;

    public function __construct()
    {
    }

    public static function index()
    {
        self::addAssets();

        $title = 'Error';
        $data = array(
            'title' => $title,
        );

        self::$view->assign($data);
        self::$view->render('index');
    }
}
