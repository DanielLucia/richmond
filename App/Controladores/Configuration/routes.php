<?php

return array(
  array('GET','/configuration/', 'configurationController#index', 'configuration'),
  array('GET','/configuration/usuarios/', 'configurationController#usuarios', 'usuarios'),
  array('GET','/configuration/grupos/', 'configurationController#grupos', 'grupos'),
  array('GET','/configuration/widgets/', 'configurationController#widgets', 'widgets'),
);
