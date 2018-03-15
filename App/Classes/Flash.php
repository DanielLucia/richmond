<?php
namespace Escuchable\App;

use Escuchable\App\Session;

class Flash extends App
{
    public static function set($content, $type = 'info', $title = 'app')
    {
        Session::set('flash.content', json_encode(array('content' => $content, 'title' => $title, 'type' => $type)));
        return;
    }
    public static function get()
    {
        $content = Session::get('flash.content');
        Session::set('flash.content', false);
        return $content;
    }
}
