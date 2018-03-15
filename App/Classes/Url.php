<?php
namespace Escuchable\App;

class Url extends App
{
    public static function generate($routeName, $params = array())
    {
        return self::$router->generate($routeName, $params);
    }

    public static function link($url)
    {
        return substr(BASE_URL, 0, -1) . $url;
    }

    public static function redirect($url, $permanent = false)
    {
        if ($permanent) {
            header('HTTP/1.1 301 Moved Permanently');
        }
        header('Location: ' . $url);
        exit();
    }

    public static function actual() {
        return (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public static function isHttps() {
        return !(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off");
    }

    public static function checkHttps() {
        if (!Url::isHttps() && getenv('FORCE_HTTPS')) {
            Url::redirect(str_replace('http:', 'https:', Url::actual()));
        }
    }

}
