<?php
   date_default_timezone_set('Europe/Brussels');

   require_once('../../.db_password.php');

   global $db_config;
   $db_config = array(
      'driver' => 'pgsql',
      'username' => $username,
      'password' => $password,
      'schema' => 'quackr_r0428905',
      'dsn' => array(
         'host' => 'gegevensbanken.khleuven.be',
         //TODO -> vind database met voldoende rechten
         'dbname' => 'PROBEEr',
         'port' => '51415',
      )
   );
?>
