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
use Escuchable\Modelos\Widgets;

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
        if (!Cronjobs::whereSlug('email')->first()) {
            Cronjobs::create(array(
                'slug' => 'email',
                'programacion' => '*/5 0 0 0 0',
                'class' => 'emailModule',
                'method' => 'Cron',
            ));
        }

        if (!Widgets::whereSlug('email')->first()) {
            Widgets::create([
                'slug' => 'email',
                'titulo' => 'Bandeja de entrada',
                'descripcion' => 'Muestra los últimos emails',
                'class' => 'emailModule',
                'method' => 'Widget',
            ]);
        }


        DB::statement(Utils::createTable(Utils::table(self::$db['table']), self::$db['fields']));
        DB::statement('ALTER TABLE `'.Utils::table(self::$db['table']).'` CHANGE COLUMN `'.self::$db['primary'].'` `'.self::$db['primary'].'` INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`'.self::$db['primary'].'`)');
    }

    public static function uninstall()
    {
        DB::statement('DROP TABLE ' . Utils::table(self::$db['table']));

        Cronjobs::whereSlug('email')->delete();
        Widgets::whereSlug('email')->delete();
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

    public static function Widget() {

    }
}
