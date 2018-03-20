<?php
namespace Escuchable\App;

class Session {

    private static $clavex = '';
    private static $k = '';
    private static $tiempo;
    private static $md5s;

// Crea un ID de sesion relacionado a una llave y a la IP del usuario
    public function __construct($clave = NULL, $tiempo) {
        if (is_null($clave)) {
            self::limpiar();
            print_r("Autorización no válida. Acceso denegado");
            exit();
        } elseif (!is_null($clave)) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $ip = Tools::getIP();
            $md5 = (md5($clave) + md5($ip));

            if ($tiempo == 0) {
                self::$tiempo = self::encriptar(time());
                self::$md5s = self::encriptar(md5($clave) + md5($ip));
                self::$clavex = $clave;
            } elseif ((md5($clave) + md5($ip) == self::desencriptar(self::$md5s)) and ( (time() - self::$desencriptar(self::$tiempo)) < $tiempo)) {
                self::$tiempo = self::encriptar(time());
                self::$md5s = self::encriptar(md5($clave) + md5($ip));
                self::$clavex = $clave;
            } else {
                self::limpiar();
                print_r('Autorización no válida. Acceso denegado');
                exit;
            }
        } else {
            self::limpiar();
            print_r('Autorización no válida. Acceso denegado');
            exit;
        }
    }

    public static function open($clave = NULL, $tiempo) {
        if (is_null($clave)) {
            self::limpiar();
            print_r("Autorización no válida. Acceso denegado");
            exit();
        } elseif (!is_null($clave)) {
            if (!isset($_SESSION)) {
                session_start();
            }
            $ip = Tools::getIP();
            $md5 = (md5($clave) + md5($ip));

            if ($tiempo == 0) {
                self::$tiempo = self::encriptar(time());
                self::$md5s = self::encriptar(md5($clave) + md5($ip));
                self::$clavex = $clave;
            } elseif ((md5($clave) + md5($ip) == self::desencriptar(self::$md5s)) and ( (time() - self::$desencriptar(self::$tiempo)) < $tiempo)) {
                self::$tiempo = self::encriptar(time());
                self::$md5s = self::encriptar(md5($clave) + md5($ip));
                self::$clavex = $clave;
            } else {
                self::limpiar();
                print_r('Autorización no válida. Acceso denegado');
                exit;
            }
        } else {
            self::limpiar();
            print_r('Autorización no válida. Acceso denegado');
            exit;
        }
    }

// _SET: es para agregarle un valor a una sesion, de no estar registrada la registra
    public static function set($variable, $valor) {
        if (isset($_SESSION[md5($variable . self::$clavex)] )) {
            if ($_SESSION[md5($variable . self::$clavex)] == false) {
                self::registrar(md5($variable . self::$clavex));
            }
        }


        $_SESSION[md5($variable . self::$clavex)] = self::encriptar($valor);
    }

// _GET: Obtiene el valor de una sesion, de no estar registrada regresa false
    public static function get($variable) {
        if (isset($_SESSION[md5($variable . self::$clavex)]))
            return self::desencriptar($_SESSION[md5($variable . self::$clavex)]);
        else
            return false;
    }

// Registra la variable como sesion
    private static function registrar($variable) {
        if (isset($_SESSION[md5($variable . self::$clavex)]) && empty($_SESSION[md5($variable . self::$clavex)]))
            $_SESSION[md5($variable . self::$clavex)];
    }

// Borra y destruye una sesion
    public function borrar($variable) {
        $_SESSION[md5($variable . self::$clavex)] = '';
    }

// Destruye por completo todas las sesiones
    public function limpiar() {
        session_unset();
    }

// Funcion para saber cuantos
    public function usuarioEnlinea() {
        $count = 0;
        $handle = opendir(session_save_path());
        if ($handle == false)
            return-1;
        while (($file = readdir($handle)) != false)
            if (ereg("^sess", $file))
                if (time() - fileatime(session_save_path() . '/' . $file) < 120) // 120 secs = 2 minutes session
                    $count++;
        closedir($handle);
        return $count;
    }

//Funciones para encriptamiento propietario de las sesiones
    private static function ed($t) {
        $r = md5(self::$k);
        $c = 0;
        $v = "";
        for ($i = 0; $i < strlen($t); $i++) {
            if ($c == strlen($r))
                $c = 0;
            $v.= substr($t, $i, 1) ^ substr($r, $c, 1);
            $c++;
        }
        return $v;
    }

    public static function encriptar($t) {
        if (!is_array($t)) {
            $t = urlencode($t);
            srand((double) microtime() * 1000000);
            $r = md5(rand(0, 32000));
            $c = 0;
            $v = "";
            for ($i = 0; $i < strlen($t); $i++) {
                if ($c == strlen($r))
                    $c = 0;
                $v.= substr($r, $c, 1) . (substr($t, $i, 1) ^ substr($r, $c, 1));
                $c++;
            }
            $v = base64_encode(self::ed($v));
            $v = str_replace('+', 'AbCdE', $v);
            return $v;
        }else {
            foreach ($t as $x => $y)
                $s[$x] = self::encriptar($y);
            return $s;
        }
    }

    public static function desencriptar($t) {
        if (!is_array($t)) {
            $t = str_replace('AbCdE', '+', $t);
            $t = self::ed(base64_decode($t));
            $v = "";
            for ($i = 0; $i < strlen($t); $i++) {
                $md5 = substr($t, $i, 1);
                $i++;
                $v.= (substr($t, $i, 1) ^ $md5);
            }
            return urldecode($v);
        } else {
            foreach ($t as $x => $y)
                $s[$x] = self::desencriptar($y);
            return $s;
        }
    }

}
