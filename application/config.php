<?php
   date_default_timezone_set('Europe/Brussels');

   global $db_config;
   $db_config = array(
      'driver' => 'mysql',
      'username' => $databaseusername,
      'password' => $databasepassword,
      'schema' => 'quackr_r0428905',
      'dsn' => array(
         'host' => 'localhost',
         'dbname' => 'c7185zrc_quackr',
         'port' => '3306',
      )
   );
?>
