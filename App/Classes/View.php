<?php
namespace Escuchable\App;

use Escuchable\App\Session;
use Escuchable\App\Flash;

class View extends \Smarty
{
    private $folderTemplate;
    public $showMenu = true;

    public function __construct($route = false)
    {
        parent::__construct();

        $this->folderTemplate = $route;
        $this->setTemplateDir(ROOT . 'App/Vistas/');
        $this->setCompileDir(ROOT . 'App/.Cache/.compiled/');
        //$this->setConfigDir('App/Vistas/Config/');
        $this->setCacheDir(ROOT . 'App/.Cache/.smarty/');
        $this->muteExpectedErrors();
        //$this->debugging = DEBUG;
        $this->addPluginsDir(ROOT . 'App/Vistas/Plugins/');
        if (boolval(getenv('SMARTY_CACHING')) == true) {
            $this->setCaching(\Smarty::CACHING_LIFETIME_CURRENT);
            $this->setCacheLifetime(300);
        }
        $this->setCompileCheck(boolval(getenv('SMARTY_FORCE_COMPILE')));
    }

    public function render($template = false, $fetch = false)
    {
        $rutaView = $this->folderTemplate . ($template ? $template : 'index') . '.tpl';
        if (is_readable($rutaView)) {
            $params = array(
                'js' => Assets::getJS(),
                'css' => Assets::getCss(),
                'css_out' => Assets::getCssOut(),
                'flash'=> Flash::get(),
                'content' => $rutaView,
                'version' => getenv('VERSION'),
                'hooks' => App::$hooks,
                'menu' => Menu::get(),
                //'session' => Session,
                'showMenu' => $this->showMenu,
            );

            $this->assign($params);

            $cache_id = md5($_SERVER['REQUEST_URI'] . (isAjax() ? '1' : '0'));

            if (boolval(getenv('MINIFY')) == true) {
                $this->registerFilter("output", "minifyHtml");
            }

            if ($fetch) {
                return $this->fetch(ROOT . 'App/Vistas/' . $template . '.tpl', $cache_id);
            } else {
                $this->display('base.tpl', $cache_id);
            }
        }
    }
}
