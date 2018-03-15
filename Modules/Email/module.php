<?php

/*
Plugin Name: Email
Slug: email
Description: PermiteU leer emails dentro del sistema
Version: 0.0.1
Author: daniellucia.es
*/

use Escuchable\App\Modulo;
use Escuchable\App\Request;
use Escuchable\App\Menu;
use Escuchable\App\Utils;

use Escuchable\Modelos\Emails;
use Escuchable\Modelos\Cronjobs;

use Illuminate\Database\Query\Expression as raw;
use Illuminate\Database\Capsule\Manager as DB;

class emailModule extends Modulo
{
    public static $db = [
        'table' => 'emails',
        'fields' => [
            ['id', 'INT'],
            ['user_id', 'INT'],
            ['title', 'VARCHAR (30)'],
            ['body', 'TEXT'],
            ['created_at', 'DATETIME'],
            ['updated_at', 'DATETIME'],
        ],
        'primary' => 'id',
    ];

    public function __construct()
    {
        $this->route = __DIR__;
        $this->has_configuration = true;

        //Hooks
        self::$hooks->action->add("form.close", function () {
            return securityModule::generateToken();
        });
        self::$hooks->action->add("form.post", function () {
            return securityModule::validateToken();
        });

        //Menu
        Menu::add(1, array('navbar'), 'Bandeja de entrada', 'inbox', 'envelope-o');
    }


    public static function install()
    {
        DB::statement(Utils::createTable(self::$db['table'], self::$db['fields']));
        DB::statement('ALTER TABLE `'.self::$db['table'].'` CHANGE COLUMN `'.self::$db['primary'].'` `'.self::$db['primary'].'` INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`'.self::$db['primary'].'`)');

        Cronjobs::create(array(
            'slug' => 'email',
            'programacion' => '*/5 0 0 0 0',
            'tarea' => 'emailModule#Cron',
        ));
    }

    public static function uninstall()
    {
        $sql = 'DROP TABLE ' . self::$db['table'];

        DB::statement($sql);

        Cronjobs::whereSlug('email')->delete();
    }

    public function configutation()
    {
    }

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
