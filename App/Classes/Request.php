<?php

namespace Escuchable\App;

class Request extends App
{
    public static function is($method) {
        return ($_SERVER['REQUEST_METHOD'] == strtoupper($method));
    }

    public static function post($key = false) {
        if ($key) {
            return filter_var($_POST[$key], FILTER_SANITIZE_STRING);
        } else {
            return $_POST;
        }
    }

    public static function get($key = false) {
        if ($key) {
            return filter_var($_GET[$key], FILTER_SANITIZE_STRING);
        } else {
            return $_GET;
        }

    }

    public static function put($key) {
        if(Request::is('put')){
            parse_str(file_get_contents('php://input'), $vars);
            return filter_var($vars[$key], FILTER_SANITIZE_STRING);
        }

        return false;
    }

    public static function delete($key) {
        if(Request::is('delete')){
            parse_str(file_get_contents('php://input'), $vars);
            return filter_var($vars[$key], FILTER_SANITIZE_STRING);
        }

        return false;
    }


}
