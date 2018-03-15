<?php

return array(
  array('GET|POST','/login/', 'authController#login', 'login'),
  array('GET','/logout/', 'authController#logout', 'logout'),
);
