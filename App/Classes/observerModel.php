<?php

namespace Escuchable\App;

class observerModel extends App {

    public static function creating($data)
    {
        dd($data);
    }

    public static function updating($data)
    {
        dd($data);
    }

    public static function deleting($data)
    {
        dd($data);
    }


}
