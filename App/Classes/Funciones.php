<?php

function minifyHtml($tpl_output, Smarty_Internal_Template $template) {
    $tpl_output = preg_replace('![\t ]*[\r\n]+[\t ]*!', '', $tpl_output);
    return $tpl_output;
}


function isAjax() {
    return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
}
