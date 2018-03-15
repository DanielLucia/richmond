<?php

namespace Escuchable\App;

class modeloObserver extends App {

    public static function creating($data)
    {
        self::$hooks->action->run("modelo.create", $data);
    }

    public static function updating($data)
    {
        self::$hooks->action->run("modelo.update", $data);
    }

    public static function deleting($data)
    {
        self::$hooks->action->run("modelo.delete", $data);
    }


}
