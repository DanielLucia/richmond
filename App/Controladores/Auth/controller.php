<?php

use Escuchable\App\Utils as Utils;
use Escuchable\App\Controller;
use Escuchable\App\Menu;
use Escuchable\App\Url;
use Escuchable\App\Form;
use Escuchable\App\Request;
use Escuchable\App\Auth;

class authController extends Controller
{
    public $login = true;

    public function __construct()
    {
    }

    public static function login()
    {
        if (Auth::isLogin()) {
            Url::redirect(Url::generate('home'));
        }

        if (Request::is('post')) {
            if (Auth::login()) {
                Url::redirect(Url::generate('home'));
            }
        }
        
        self::addAssets();

        $fields = array(
            'email' => array(
              'title' => 'E-Mail',
              'type' => 'email',
            ),
            'password' => array(
              'title' => 'Clave',
              'type' => 'password',
            ),
            'submit' => array(
              'title' => 'Login',
              'type' => 'submit',
              'class' => 'buttonBlock'
            ),
          );

        $form = new Form($fields, Url::generate('login'), 'post', 'Login');
        $data['form'] = $form->build();


        $data['title'] = 'OPEN';
        self::$view->assign($data);
        self::$view->showMenu = false;
        self::$view->render('login');
    }

    public static function register()
    {
        self::addAssets();

        $title = 'OPEN';


        self::$view->assign($data);
        self::$view->showMenu = false;
        self::$view->render('register');
    }

    public static function logout()
    {
        Auth::logout();
        Url::redirect(Url::generate('login'));

    }
}
