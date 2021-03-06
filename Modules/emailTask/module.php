<?php

/*
Plugin Name: emailTask
Slug: emailtask
Description: Sistema para leer emails dentro del propio sistema.
Version: 0.0.1
Author: daniellucia.es
Dependecies: email
*/

use Escuchable\App\Modulo;
use Escuchable\App\Request;
use Escuchable\App\Menu;
use Escuchable\App\Utils;

use Escuchable\Modelos\Emails;

use Illuminate\Database\Query\Expression as raw;
use Illuminate\Database\Capsule\Manager as DB;

class emailtaskModule extends Modulo
{

    public function __construct()
    {
        $this->route = __DIR__;
        $this->has_configuration = true;

        //Menu
        Menu::add(1, array('navbar'), 'Bandeja de entrada', 'inbox', 'envelope-o');
    }


    /*public static function install()
    {
        DB::statement(Utils::createTable(Utils::table(self::$db['table']), self::$db['fields']));
        DB::statement('ALTER TABLE `'.Utils::table(self::$db['table']).'` CHANGE COLUMN `'.self::$db['primary'].'` `'.self::$db['primary'].'` INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`'.self::$db['primary'].'`)');
    }

    public static function uninstall()
    {
        $sql = 'DROP TABLE ' . Utils::table(self::$db['table']);

        DB::statement($sql);
    }

    public function configuration()
    {
    }*/

    public static function inbox()
    {
        $title = 'Bandeja de entrada';

        $data = array(
            'title' => $title,
            'emails' => Emails::all(),
        );

        self::$view->assign($data);
        self::$view->render('index');
    }
}
