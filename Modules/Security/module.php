<?php

/*
Plugin Name: Security
Slug: security
Description: Aumentar seguridaden el sistema
Version: 0.0.1
*/

use Escuchable\App\Modulo;
use Escuchable\App\Request;
use Escuchable\App\Menu;
use Escuchable\App\Session;
use Escuchable\App\Utils;

use Escuchable\Modelos\Connections;
use Escuchable\Modelos\Widgets;

class securityModule extends Modulo
{
    public function __construct()
    {
        $this->route = __DIR__;
        $this->has_configuration = true;
        self::$modelo = include($this->route . '/.db/model.php');

        //Hooks
        self::$hooks->action->add("form.close", function () {
            return securityModule::generateToken(15);
        });

        self::$hooks->action->add('login.success', function () {
            return securityModule::saveConnection(true);
        });
        self::$hooks->action->add('login.failed', function () {
            return securityModule::saveConnection();
        });
        self::$hooks->action->add('login.before', function () {
            return securityModule::checkConnection();
        });

        //Menu
        Menu::add(10, array('configuracion'), 'Seguridad', 'security', 'shield');
    }


    public static function install()
    {
        parent::install();

        if (!Widgets::whereSlug('connections')->first()) {
            Widgets::create([
                    'slug' => 'connections',
                    'titulo' => 'Seguridad',
                    'descripcion' => 'Muestra las ips bloqueadas',
                    'class' => 'securityModule',
                    'method' => 'Widget',
                ]);
        }
    }

    public static function uninstall()
    {
        parent::uninstall();

        Widgets::whereSlug('email')->delete();
    }


    public static function generateToken($length)
    {
        $token = bin2hex(random_bytes($length));
        Session::set('form.token', $token);
        return "<input type='hidden' name='token' value='". $token ."'>";
    }

    public static function validateToken()
    {
        if (Session::get('form.token') != Request::post('token') && Request::is('post')) {
            die('Invalid Token');
        }
        Session::set('form.token', false);
    }
    public static function saveConnection($logged = false, $banned = 0)
    {
        $ip = Utils::getUserIP();
        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}/json"));

        Connections::create([
                'ip' => $ip,
                'agent' => $_SERVER['HTTP_USER_AGENT'],
                'banned' => intval($banned),
                'logged' => ($logged == true ? 1 : 0),
                'user_id' => intval(Session::get('user.id')),
                'location' => isset($details->city) ? $details->city : false,
                'hostname' => isset($details->hostname) ? $details->hostname : false,
                'org' => isset($details->org) ? $details->org : false,
            ]);
    }
    public static function checkConnection()
    {
        $connection = Connections::whereIp(Utils::getUserIP())->orderBy('created_at', 'desc')->first();
        if (isset($connection) && intval($connection->banned) == 1) {
            die('Error');
        }

        $date = new DateTime;
        $date->modify('-5 minutes');
        $formatted_date = $date->format('Y-m-d H:i:s');
        if (Connections::whereIp(Utils::getUserIP())->where('created_at', '>=', $formatted_date)->orderBy('created_at', 'desc')->count() > 3) {
            securityModule::saveConnection(false, 1);
            die('Error');
        }
    }
    public static function configuration()
    {
        $title = 'Seguridad';
        $data = array(
            'title' => $title,
            //'emails' => Emails::all(),
        );

        self::$view->assign($data);
        self::$view->render('index');
    }
}
