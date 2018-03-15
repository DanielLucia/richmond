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

class securityModule extends Modulo
{

    public function __construct()
    {
        $this->route = __DIR__;
        $this->has_configuration = true;

        \phpSec\Common\Core::setStore('filesystem:App/.Cache/.phpSec');

        //Hooks
        self::$hooks->action->add("form.close", function() {
        	return securityModule::generateToken();
        });
        self::$hooks->action->add("form.post", function() {
        	return securityModule::validateToken();
        });

        //Menu
        Menu::add(1, array('sidebar'), 'Seguridad', 'security', 'shield');
    }

    public static function generateToken() {
        $token = \phpSec\Common\Token::set('form');
        return "<input type='hidden' name='token' value='". $token ."'>";
    }

    public static function validateToken() {
        if (\phpSec\Common\Token::validate('form', Request::post('token')) ==false && Request::is('post')) {
            die('Invalid Token');
        }
    }

    public function configutation() {

    }
}
