<?php

use Escuchable\App\Session;

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.url.php
 * Type:     modifier
 * Name:     url
 * Purpose:  Formatea una url con dos parametros
 * -------------------------------------------------------------
 */
function smarty_modifier_session($key)
{
    echo Session::get($key);
}
