<?php
namespace Escuchable\App;

use Hautelook\Phpass\PasswordHash;
use Escuchable\App\Session;
use Escuchable\App\Flash;

use Escuchable\Modelos\Usuarios;

class Auth extends App
{
    public static function login()
    {
        if (Request::post('email') && Request::post('password')) {
            $data = Usuarios::where('email', Request::post('email'))->first();
            if ((bool) $data !== false) {
                if (self::$hasher->CheckPassword(Request::post('password'), $data->password)) {
                    Session::set('user.id', $data->id);
                    Session::set('user.name', $data->nombre);
                    Session::set('user.email', $data->email);

                    return true;
                } else {
                    Flash::set('El usuario o la clave son incorrectas', 'error', 'Vaya!');
                }
            } else {
                Flash::set('El usuario o la clave son incorrectas', 'error', 'Vaya!');
            }

            return false;
        } else {
            Flash::set('Faltan campos', 'error', 'Oh!');
        }
        return false;
    }

    public function register()
    {
        $usuario = Usuarios::create(array(
                        'nombre' => Request::post('nombre'),
                        'email' => Request::post('email'),
                        'password' => self::$hasher->HashPassword(Request::post('password')),
                    ));

        Session::set('user.id', $usuario->id);
        Session::set('user.name', Request::post('nombre'));
        Session::set('user.email', Request::post('email'));
    }

    public static function isLogin()
    {
        return intval(Session::get('user.id')) > 0;
    }

    public static function logout()
    {
        Session::set('user.id', false);
        Session::set('user.name', false);
        Session::set('user.email', false);
    }
}
