<?php

use Escuchable\App\Utils;

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.url.php
 * Type:     modifier
 * Name:     url
 * Purpose:  Formatea una url con dos parametros
 * -------------------------------------------------------------
 */
function smarty_modifier_url($routeName, $params)
{
    echo Utils::generate($routeName, $params);
}
