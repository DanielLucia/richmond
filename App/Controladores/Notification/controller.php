<?php

use Escuchable\App\Utils as Utils;
use Escuchable\App\Controller;
use Escuchable\App\Menu;
use Escuchable\App\Url;

/*use Escuchable\Modelos\Categorias;
use Escuchable\Modelos\Podcast;
use Escuchable\Modelos\Episodios;*/

class notificationController extends Controller
{

    public function __construct()
    {
        Menu::add(4, array('navbar'), 'Notificaciones', 'notifications', 'comment-o');
    }

    public static function index()
    {
        self::addAssets();

        $title = 'Notificaciones';
        $data = array(
            'title' => $title,
        );

        self::$view->assign($data);
        self::$view->render('index');

    }

}
