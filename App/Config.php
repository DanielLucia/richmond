<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->load();

$capsule = new Capsule;
$capsule->addConnection([
    'driver'    => getenv('DB_DRIVER'),
    'host'      => getenv('DB_HOST'),
    'database'  => getenv('DB_DB'),
    'username'  => getenv('DB_USER'),
    'password'  => getenv('DB_PASS'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => getenv('DB_PREFIX'),
]);
$capsule->setEventDispatcher(new Dispatcher(new Container));
$capsule->getContainer()->bind('paginator', 'Illuminate\Pagination\Paginator');
$capsule->getContainer()->bind('LengthAwarePaginator', 'Illuminate\Pagination\LengthAwarePaginator');
$capsule->setAsGlobal();
$capsule->bootEloquent();

//Url principal
define('BASE_URL', getenv('BASE_URL'));

//Otras rutas
define('PUBLIC_FOLDER', BASE_URL . 'Publico/');
define('MODULES_FOLDER', BASE_URL . 'Modulos/');

include(ROOT . 'App/Classes/Funciones.php');
