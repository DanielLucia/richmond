<?php

use Escuchable\App\App;

session_start();

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);

include(ROOT . 'App/.Composer/autoload.php');
include(ROOT . 'App/Config.php');

$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

App::init();
