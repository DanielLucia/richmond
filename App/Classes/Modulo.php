<?php
namespace Escuchable\App;

use Illuminate\Database\Query\Expression as raw;
use Illuminate\Database\Capsule\Manager as DB;

class Modulo extends App
{
    public $title;
    public $description;
    public $route;
    public $has_configuration = false;
    public static $modelo = false;

    public static function getDetail($plugin_file)
    {
        $default_headers = array(
                            'Name' => 'Plugin Name',
                            'PluginURI' => 'Plugin URI',
                            'Version' => 'Version',
                            'Description' => 'Description',
                            'Author' => 'Author',
                            'AuthorURI' => 'Author URI',
                            'TextDomain' => 'Text Domain',
                            'DomainPath' => 'Domain Path',
                            'Network' => 'Network',
                            'Slug' => 'Slug',
                            'Dependecies' => 'Dependecies',
                            '_sitewide' => 'Site Wide Only',
                    );

        $plugin_data = Modulo::getFileData($plugin_file, $default_headers, 'plugin');

        $plugin_data['Network'] = ('true' == strtolower($plugin_data['Network']));
        unset($plugin_data['_sitewide']);

        $plugin_data['Title']      = $plugin_data['Name'];
        $plugin_data['AuthorName'] = $plugin_data['Author'];

        $plugin_data = array_map('trim', $plugin_data);

        return $plugin_data;
    }

    public static function getFileData($file, $default_headers, $context = '')
    {
        // We don't need to write to the file, so just open for reading.
        $fp = fopen($file, 'r');

        // Pull only the first 8kiB of the file in.
        $file_data = fread($fp, 8192);

        // PHP will close file handle, but we are good citizens.
        fclose($fp);

        // Make sure we catch CR-only line endings.
        $file_data = str_replace("\r", "\n", $file_data);

        $all_headers = $default_headers;

        foreach ($all_headers as $field => $regex) {
            if (preg_match('/^[ \t\/*#@]*' . preg_quote($regex, '/') . ':(.*)$/mi', $file_data, $match) && $match[1]) {
                $all_headers[ $field ] =  $match[1];
            } else {
                $all_headers[ $field ] = '';
            }
        }

        return $all_headers;
    }

    public static function installed($module) {
        if (array_key_exists($module, self::$modules)) {
            return self::$modules[$module]['installed'];
        }

        return false;
    }

    public static function install() {
        foreach (static::$modelo['database'] as $db) {
            //dd(Utils::createTable(Utils::table($db['table']), $db['fields']));
            DB::statement(Utils::createTable(Utils::table($db['table']), $db['fields']));
            DB::statement('ALTER TABLE `'.Utils::table($db['table']).'` CHANGE COLUMN `'.$db['primary'].'` `'.$db['primary'].'` INT(11) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`'.$db['primary'].'`)');
        }
    }

    public static function uninstall() {
        foreach (static::$modelo['database'] as $db) {
            DB::statement('DROP TABLE ' . Utils::table($db['table']));
        }
    }
}
