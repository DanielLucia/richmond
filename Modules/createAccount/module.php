<?php

/*
Plugin Name: Create account
Slug: create-account
Description: Crear cuenta de usuario con validación.
Version: 0.0.1
Author: daniellucia.es
*/

use Escuchable\App\Modulo;
use Escuchable\App\Request;
use Escuchable\App\Url;

class createaccountModule extends Modulo
{
    public $login = true;

    public function __construct()
    {
        $this->route = __DIR__;

        //Hooks
        self::$hooks->action->add("form.close", function() {
        	return createAccountModule::createAccountLink();
        });

        self::$hooks->action->add("home", function() {
        	return 'Módulo createAccount en home';
        });
    }

    public static function createAccountLink() {
        return '<p><a href="'.Url::generate('create-account').'"><i class="fa fa-plus" aria-hidden="true"></i> Crear cuenta</a></p>';
    }


    public static function createAccount() {
        $title = 'Crear cuenta';

        $data = array(
            'title' => $title,
        );
        self::$view->showMenu = false;
        self::$view->assign($data);
        self::$view->render('index');
    }
}
