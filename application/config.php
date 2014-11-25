<?php
   date_default_timezone_set('Europe/Brussels');

   require_once('../../.db_password.php');

   global $db_config;
   $db_config = array(
      'driver' => 'mysql',
      'username' => $username,
      'password' => $password,
      'schema' => 'quackr_r0428905',
      'dsn' => array(
         'host' => 'localhost',
         'dbname' => 'c7185zrc_quackr',
         'port' => '3306',
      )
   );
?>
