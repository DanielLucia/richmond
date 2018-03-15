<?php

use Escuchable\App\Utils as Utils;
use Escuchable\App\Controller;
use Escuchable\App\Menu;
use Escuchable\App\Url;

use Escuchable\Modelos\Modulos;

class backupsController extends Controller
{
    public function __construct()
    {
        Menu::add(99, array('configuracion'), 'Copias de seguridad', 'backups', 'hdd-o');
        self::addAssets();
    }

    public static function index()
    {

        $title = 'Copias de seguridad';

        $data = array(
            'title' => $title,
            //'modules' => self::$modules,
        );

        self::$view->assign($data);
        self::$view->render('index');

    }

}
