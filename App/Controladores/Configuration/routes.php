<?php

return array(
  array('GET','/configuracion/', 'configurationController#index', 'configuration'),
  array('GET','/configuracion/usuarios/', 'configurationController#usuarios', 'usuarios'),
  array('GET','/configuracion/grupos/', 'configurationController#grupos', 'grupos'),
);
