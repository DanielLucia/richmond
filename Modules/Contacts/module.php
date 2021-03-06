<?php

/*
Plugin Name: Contacts
Slug: contacts
Description: Gestión de contactos
Version: 0.0.1
Author: daniellucia.es
*/

use Escuchable\App\Modulo;
use Escuchable\App\Request;
use Escuchable\App\Menu;
use Escuchable\App\Utils;
use Escuchable\App\Session;
use Escuchable\App\Url;

use Escuchable\Modelos\Contacts;

use Illuminate\Database\Query\Expression as raw;
use Illuminate\Database\Capsule\Manager as DB;

class contactsModule extends Modulo
{
    public function __construct()
    {
        $this->route = __DIR__;
        $this->has_configuration = false;
        self::$modelo = include($this->route . '/.db/model.php');

        //Menu
        Menu::add(1, array('sidebar'), 'Contactos', 'contacts', 'address-book-o');

    }


    public static function install()
    {
        parent::install();
    }

    public static function uninstall()
    {
        parent::uninstall();
    }

    public function configuration()
    {
    }

    public static function index()
    {

        $title = 'Contactos';
        $data = array(
            'title' => $title,
        );

        self::$view->assign($data);
        self::$view->render('index');
    }

    public static function view($id)
    {

        $title = 'Contactos';
        $data = array(
            'title' => $title,
        );

        self::$view->assign($data);
        self::$view->render('detail');
    }

    public static function add()
    {

        $title = 'Contactos';
        $data = array(
            'title' => $title,
        );

        self::$view->assign($data);
        self::$view->render('detail');
    }
}
