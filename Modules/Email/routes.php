<?php

return array(
  array('GET|POST','/configuration/emails-accounts/', 'emailModule#configuration', 'emails_accounts'),
  array('GET','/inbox/', 'emailModule#inbox', 'inbox'),
  array('GET','/inbox/sync/', 'emailModule#sync', 'sync_inbox'),
  array('GET','/inbox/[:uid]/', 'emailModule#inboxDetail', 'inbox_detail'),
);
