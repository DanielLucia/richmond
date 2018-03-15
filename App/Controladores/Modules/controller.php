<?php

use Escuchable\App\Utils as Utils;
use Escuchable\App\Controller;
use Escuchable\App\Menu;
use Escuchable\App\Url;

use Escuchable\Modelos\Modulos;

class modulesController extends Controller
{
    public function __construct()
    {
        Menu::add(0, array('sidebar'), 'Módulos', 'modules', 'plug');
        self::addAssets();
    }

    public static function index()
    {

        $title = 'Configuración de módulos';

        $data = array(
            'title' => $title,
            'modules' => self::$modules,
        );

        self::$view->assign($data);
        self::$view->render('index');

    }

    public static function install($module)
    {
        $moduleDB = self::getModule($module);
        if ($moduleDB->class_name && method_exists($moduleDB->class_name, 'install')) {
            call_user_func(array($moduleDB->class_name, 'install'));
        }

        $moduleDB->instalado = 1;
        $moduleDB->save();

        Url::redirect(Url::generate('modules'));

    }

    public static function uninstall($module)
    {
        $moduleDB = self::getModule($module);
        if ($moduleDB->class_name && method_exists($moduleDB->class_name, 'uninstall')) {
            call_user_func(array($moduleDB->class_name, 'uninstall'));
        }
        $moduleDB->delete();

        Url::redirect(Url::generate('modules'));

    }

    public static function getModule($module) {

        $moduleDB = Modulos::whereSlug($module)->first();

        if (!$moduleDB) {
            Modulos::create(
                array(
                    'slug' => self::$modules[$module]['Slug'],
                    'titulo' => self::$modules[$module]['Title'],
                    'descripcion' => self::$modules[$module]['Description'],
                    'class_name' => self::$modules[$module]['class_name'],
                )
            );

            return self::getModule($module);
        } else {
            return $moduleDB;
        }
    }
}
