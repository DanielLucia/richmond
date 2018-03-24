<?php

use Escuchable\App\Utils as Utils;
use Escuchable\App\Controller;
use Escuchable\App\Menu;
use Escuchable\App\Url;

use Escuchable\Modelos\Cronjobs;

class cronController extends Controller
{
    public $login = true;

    public function __construct()
    {
    }

    public static function cron()
    {
        $cronjobs = Cronjobs::all();

        foreach ($cronjobs as $cronjob) {
            echo '<pre>'.$cronjob->programacion.'</pre>';
            $cron = Cron\CronExpression::factory($cronjob->programacion);
            if($cron->isDue()) {
                echo '<pre>'.$cronjob->slug.' | '.$cronjob->class.' | '.$cronjob->method.'</pre>';
                call_user_func_array(array($cronjob->class, $cronjob->method), array(true));
            }
        }
    }
}
