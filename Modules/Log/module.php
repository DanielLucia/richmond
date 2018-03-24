<?php

/*
Plugin Name: Log
Slug: log
Description: Crea un log de todo lo que ocurre en el sistema
Version: 0.0.1
*/

use Escuchable\App\Modulo;
use Escuchable\App\Request;
use Escuchable\App\Menu;
use Escuchable\App\Session;
use Escuchable\App\Utils;

use Escuchable\Modelos\logHistory;

use Illuminate\Database\Query\Expression as raw;
use Illuminate\Database\Capsule\Manager as DB;

class logModule extends Modulo
{
    public static $db = [
        'table' => 'log_history',
        'fields' => [
            ['id', 'INT'],
            ['user_id', 'INT'],
            ['accion', 'VARCHAR (30)'],
            ['modelo', 'VARCHAR (30)'],
            ['data', 'TEXT'],
            ['created_at', 'DATETIME'],
            ['updated_at', 'DATETIME'],
        ],
        'primary' => 'id',
    ];

    public function __construct()
    {
        $this->route = __DIR__;
        $this->has_configuration = false;

        //Hooks
        self::$hooks->action->add("modelo.create", function($model) {
        	return logModule::saveLog('create', $model);
        });
        self::$hooks->action->add("modelo.update", function($model) {
        	return logModule::saveLog('create', $model);
        });
        self::$hooks->action->add("modelo.delete", function($model) {
        	return logModule::saveLog('create', $model);
        });


        //Menu
        Menu::add(1, array('sidebar'), 'Log', 'log', 'file-text-o');
    }

    public static function saveLog($action, $model) {
        if ($model->getTable() == self::$db['table'] || !$model) {
            return;
        }

        $data = array(
            'user_id' => Session::get('user.id'),
            'modelo' => $model->getTable(),
            'accion' => $action,
            'data' => false,
        );

        logHistory::create($data);

    }
    public function configuration() {
        $title = 'Log';
        $data = array(
            'title' => $title,
            //'emails' => Emails::all(),
        );

        self::$view->assign($data);
        self::$view->render('index');
    }

    public static function install()
    {
        //DB::statement(Utils::createTable(Utils::table(self::$db['table']), self::$db['fields']));
        //DB::statement('ALTER TABLE `'.Utils::table(self::$db['table']).'` CHANGE COLUMN `'.self::$db['primary'].'` `'.self::$db['primary'].'` INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`'.self::$db['primary'].'`)');
    }

    public static function uninstall()
    {
        //$sql = 'DROP TABLE ' . Utils::table(self::$db['table']);
        //DB::statement($sql);
    }
}
