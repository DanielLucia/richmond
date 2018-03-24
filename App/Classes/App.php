<?php
namespace Escuchable\App;

use Escuchable\App\Controller;
use Escuchable\App\View;

use Escuchable\Controladores;

use Katzgrau\KLogger\Logger as Logger;
use AltoRouter as AltoRouter;
use daniellucia\Hooks\Manager as Manager;
use Hautelook\Phpass\PasswordHash;
use Carbon\Carbon;

use Escuchable\App\Auth;
use Escuchable\App\Menu;
use Escuchable\App\Url;

use Escuchable\Modelos\Modulos;
use Escuchable\Modelos\Categorias;

class App
{
    public static $view;
    public static $logger;
    public static $router;
    public static $hooks;
    public static $section;
    private static $fileController = 'controller.php';
    private static $fileModule = 'module.php';
    private static $fileRoute = 'routes.php';
    public static $routes;
    public static $controllers;
    public static $modules;
    public static $hasher;
    public static $assets;

    public static function init()
    {
        Url::checkHttps();

        self::$hooks = new Manager;
        if (Request::is('post')) {
            self::$hooks->action->run("form.post");
        }
        Carbon::setLocale('es');
        self::$router = new AltoRouter();
        self::$logger = new Logger(ROOT . 'App/Log');
        self::$hasher = new PasswordHash(8, false);
        self::$assets = new \Stolz\Assets\Manager();
        self::loadControllers();
        self::loadModules();
        self::generateRoute();
    }

    public static function loadControllers()
    {
        self::$routes = array();
        $controllersDir = ROOT . 'App' . DS . 'Controladores' . DS;
        $controllers = scandir($controllersDir);
        $routesTemp = array();

        foreach ($controllers as $controller) {
            $controllerDir = $controllersDir . $controller . DS;
            $fileController = $controllerDir . self::$fileController;
            $fileRoute = $controllerDir . DS . self::$fileRoute;
            $folderView = $controllerDir . 'Views' . DS;
            $controllerName = strtolower($controller).'Controller';

            if (file_exists($fileRoute)) {
                $routesTemp = include_once($fileRoute);
                if (!empty($routesTemp)) {
                    foreach ($routesTemp as $route) {
                        if (is_dir($folderView)) {
                            self::$section[$route[3]] = array('folder' => $folderView, 'controller' => $controllerName);
                        }

                        self::$routes[] = $route;
                    }
                }
            }

            if (file_exists($fileController)) {
                include_once($fileController);
                self::$controllers[] = $controllerName;
            }
        }

        if (!empty(self::$routes)) {
            foreach (self::$routes as $route) {
                if (is_array($route)) {
                    self::$router->map($route[0], $route[1], $route[2], $route[3]);
                }
            }
        }
        if (!empty(self::$controllers)) {
            foreach (self::$controllers as $controllerName) {
                $controllerTemp = new $controllerName;
            }
        }
    }


    public static function loadModules()
    {
        self::$routes = array();
        $modulesDir = ROOT . 'Modules' . DS;
        $modules = scandir($modulesDir);
        $routesTemp = array();
        $modulesInstalled = Modulos::getInstalled();

        foreach ($modules as $module) {
            if (strlen($module) <= 2) {
                continue;
            }
            $moduleDir = $modulesDir . $module . DS;
            $fileModule = $moduleDir . self::$fileModule;
            $fileRoute = $moduleDir . DS . self::$fileRoute;
            $folderView = $moduleDir . 'Views' . DS;
            $moduleName = strtolower($module).'Module';

            if (file_exists($fileRoute)) {
                $routesTemp = include_once($fileRoute);
                if (!empty($routesTemp)) {
                    foreach ($routesTemp as $route) {
                        if (is_dir($folderView)) {
                            self::$section[$route[3]] = array('folder' => $folderView, 'controller' => $moduleName);
                        }

                        self::$routes[] = $route;
                    }
                }
            }

            if (file_exists($fileModule)) {

                include_once($fileModule);
                $moduleDetail = Modulo::getDetail($fileModule);

                self::$modules[$moduleDetail['Slug']] = $moduleDetail;
                self::$modules[$moduleDetail['Slug']]['ModuleName'] = $moduleName;
                self::$modules[$moduleDetail['Slug']]['folder'] = $module;
                self::$modules[$moduleDetail['Slug']]['Dependecies'] = explode(',', self::$modules[$moduleDetail['Slug']]['Dependecies']);
            }
        }

        if (!empty(self::$routes)) {
            foreach (self::$routes as $route) {
                if (is_array($route)) {
                    self::$router->map($route[0], $route[1], $route[2], $route[3]);
                }
            }
        }
        if (!empty(self::$modules)) {
            foreach (self::$modules as $moduleSlug => $module) {
                $moduleName = $module['ModuleName'];
                $installed = array_key_exists($moduleSlug, $modulesInstalled);
                self::$modules[$moduleSlug]['class_name'] = $moduleName;
                if ($installed) {
                    $moduleTemp = new $moduleName;

                    $urlAction = Url::generate('modules_uninstall', array( 'module' => self::$modules[$moduleSlug]['Slug']));
                    $urlActionConfiguration = ($moduleTemp->has_configuration ? Url::generate('modules_configuration', array('action' => 'configuration', 'module' => self::$modules[$moduleSlug]['Slug'])) : false);

                    self::$modules[$moduleSlug]['route'] = $moduleTemp->route;
                    self::$modules[$moduleSlug]['configuration'] = $urlActionConfiguration;
                    self::$modules[$moduleSlug]['installed'] = true;
                    self::$modules[$moduleSlug]['url_action'] = $urlAction;

                    $folderModelos = $modulesDir . self::$modules[$moduleSlug]['folder'] . DS . 'Modelos' . DS;
                    if (is_dir($folderModelos)) {
                        $modelos = scandir($folderModelos);
                        foreach ($modelos as $modelo) {
                            if (strlen($modelo) <= 2) {
                                continue;
                            }
                            $fileModelo = $folderModelos . $modelo;
                            include_once($fileModelo);
                        }
                    }

                } else {
                    $urlAction = Url::generate('modules_install', array('action' => 'install', 'module' => self::$modules[$moduleSlug]['Slug']));

                    self::$modules[$moduleSlug]['installed'] = false;
                    self::$modules[$moduleSlug]['url_action'] = $urlAction;
                }

            }
        }
    }

    private static function generateRoute()
    {
        $match = self::$router->match();
        $map = explode('#', $match['target']);
        if (is_array($match) && is_callable(array($map[0], $map[1]))) {
            $folderView = self::$section[$match['name']]['folder'];
            $controller = new self::$section[$match['name']]['controller'];

            Menu::setActual($match['name']);

            if ((!isset($controller->login) || $controller->login == false) && !Auth::isLogin()) {
                Url::redirect(Url::generate('login'));
            }

            self::$view = new View($folderView);
            call_user_func_array(array($map[0], $map[1]), $match['params']);
        } else {

            $error = '<h1>Not found</h1>';
            $error .= '<h1>Match</h1>';
            $error .= '<pre>'.print_r($match, 1).'</pre>';
            $error .= '<h1>Controllers</h1>';
            $error .= '<pre>'.print_r(self::$controllers, 1).'</pre>';
            $error .= '<pre>'.print_r(self::$modules, 1).'</pre>';
            $error .= '<h1>Map</h1>';
            $error .= '<pre>'.print_r($map, 1).'</pre>';
            $error .= '<h1>Rutas</h1>';
            $error .= '<pre>'.print_r(self::$router, 1).'</pre>';
            echo $error;
            /*Flash::set($error, 'error', 'Vaya!');
            Url::redirect(Url::generate('error'));*/

            self::$logger->debug('No ha habido coincidencias en la ruta', array($match));
            //Url::redirect(Url::generate('error'));
        }
    }
}
