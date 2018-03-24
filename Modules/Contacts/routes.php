<?php

return array(
  array('GET','/contacts/', 'contactsModule#index', 'contacts'),
  array('GET','/contacts/[:id]/', 'contactsModule#view', 'contacts_view'),
  array('GET','/contacts/add/', 'contactsModule#add', 'contacts_add'),
);
