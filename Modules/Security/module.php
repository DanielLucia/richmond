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

class securityModule extends Modulo
{

    public function __construct()
    {
        $this->route = __DIR__;
        $this->has_configuration = true;

        //Hooks
        self::$hooks->action->add("form.close", function() {
        	return securityModule::generateToken(15);
        });
        self::$hooks->action->add("form.post", function() {
        	return securityModule::validateToken();
        });

        //Menu
        Menu::add(10, array('configuracion'), 'Seguridad', 'security', 'shield');
    }

    public static function generateToken($length) {
        $token = bin2hex(random_bytes($length));
        Session::set('form.token', $token);
        return "<input type='hidden' name='token' value='". $token ."'>";
    }

    public static function validateToken() {
        if (Session::set('form.token') != Request::post('token') && Request::is('post')) {
            die('Invalid Token');
        }
    }

    public static function configuration() {
        $title = 'Seguridad';
        $data = array(
            'title' => $title,
            //'emails' => Emails::all(),
        );

        self::$view->assign($data);
        self::$view->render('index');
    }
}
