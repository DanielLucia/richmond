<?php

return array(
  array('GET','/modulos/', 'modulesController#index', 'modules'),
  array('GET','/modulos/install/[:module]/', 'modulesController#install', 'modules_install'),
  array('GET','/modulos/uninstall/[:module]/', 'modulesController#uninstall', 'modules_uninstall'),
  array('GET','/modulos/configuration/[:module]/', 'modulesController#configuration', 'modules_configuration'),
);
