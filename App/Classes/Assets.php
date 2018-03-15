<?php
namespace Escuchable\App;

use MatthiasMullie\Minify;

class Assets extends App
{
    private static $_js = array();
    private static $_css = array();
    private static $_css_out = array();
    private static $_route_css = 'Publico/css/';
    private static $_route_js = 'Publico/js/';

    /**
        * Añade un archivo css al listado.
        * No hace falta ruta completa, siempre y cuando el archivo exista en el directorio Publico/css
        * Se puede añadir archivos con url absolutas.
        * Si el archivo no existe en local, no se añadirá para que no devuelva errores 404
        *
        * @param string nombre del archivo.
        * @param string atributo media.
        * @return false
        */
    public static function addCss($filename, $ruta = false, $media = 'screen')
    {
        if (substr($filename, 0, 4) == 'http') {
            self::$_css[] = array('filename' => $filename, 'media' => $media);
            self::$_css_out[] = array('filename' => $filename, 'media' => $media);
        } else {
            self::$_css[] = array(
                        'absolute' => ROOT . 'Publico' . DS . 'css' .  DS . $filename,
                      'min' => 'css' . DS . $filename,
                      'filename' => (!$ruta ? BASE_URL . self::$_route_css : BASE_URL . $ruta) . $filename,
                      'media' => $media);
        }
    }


    /**
    * Añade un archivo javascript al listado.
    * No hace falta ruta completa, siempre y cuando el archivo exista en el directorio Publico/js
    * Se puede añadir archivos con url absolutas.
    * Si el archivo no existe en local, no se añadirá para que no devuelva errores 404
    *
    * @param string nombre del archivo.
    * @return false
    */
    public static function addJS($filename, $ruta = false)
    {
        if (substr($filename, 0, 4) == 'http') {
            self::$_js[] = array('filename' => $filename);
        } else {
            self::$_js[] = array(
                'absolute' => ROOT . 'Publico' . DS . 'js' .  DS . $filename,
                  'min' => 'js' . DS . $filename,
                  'filename' => (!$ruta ? BASE_URL . self::$_route_js : BASE_URL.$ruta) . $filename);
        }
    }


    /**
    * Obtiene el array de todos los archivos CSS simplificado para minify
    *
    * @return array
    */
    public static function getCss()
    {
        if (boolval(getenv('MINIFY'))== true) {
            if (!Assets::minifiedCssExists() || boolval(getenv('FORCE_MINIFY')) == true) {
                Assets::minifyCss();
                self::$logger->info('Rehaciendo el archivo minified.css');
            }

            self::$_css = array();
            Assets::addCss('minified.css');
            self::$_css = array_merge(self::$_css, self::$_css_out);
        }

        return self::$_css;
    }


    /**
    * Obtiene el array de los archivos CSS alojados fuera
    *
    * @return array
    */
    public static function getCssOut()
    {
        return self::$_css_out;
    }


    /**
    * Obtiene el array de todos los archivos javascript
    *
    * @return array
    */
    public static function getJS()
    {
        if (boolval(getenv('MINIFY')) == true) {
            if (!Assets::minifiedJsExists() || boolval(getenv('FORCE_MINIFY')) == true) {
                Assets::minifyJs();
                self::$logger->info('Rehaciendo el archivo minified.js');
            }

            self::$_js = array();
            Assets::addJs('minified.js');
        }

        return self::$_js;
    }

    public static function minifyCss()
    {
        $minifier = new Minify\CSS();
        $cssFiles = self::$_css;
        foreach ($cssFiles as $file) {
            if ($file['absolute']) {
                $minifier->add($file['absolute']);
            }
        }

        file_put_contents(ROOT . 'Publico' . DS . 'css' .  DS . 'minified.css', $minifier->minify());
    }

    public static function minifyJs()
    {
        $minifier = new Minify\JS();
        $cssFiles = self::$_js;
        foreach ($cssFiles as $file) {
            if ($file['absolute']) {
                $minifier->add($file['absolute']);
            }
        }

        file_put_contents(ROOT . 'Publico' . DS . 'js' .  DS . 'minified.js', $minifier->minify());
    }

    public static function minifiedCssExists()
    {
        return file_exists(ROOT . 'Publico' . DS . 'css' .  DS . 'minified.css');
    }

    public static function minifiedJsExists()
    {
        return file_exists(ROOT . 'Publico' . DS . 'js' .  DS . 'minified.js');
    }
}
