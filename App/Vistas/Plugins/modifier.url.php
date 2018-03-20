<?php

use Escuchable\App\Url;

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.url.php
 * Type:     modifier
 * Name:     url
 * Purpose:  Formatea una url con dos parametros
 * -------------------------------------------------------------
 */
function smarty_modifier_url($routeName, $params = array())
{
    echo Url::generate($routeName, $params);
}
