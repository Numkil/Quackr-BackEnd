<?php
   /*User_Mapper.php -- implements the specific code for adding/retrieving a user from the database
   Uses DB.php->execute to actually contact the server

   Users table layout for future reference
   +--------------------------------------------------------+
   |             id             | accesslevel  |   score    |
   +--------------------------------------------------------+
   |   google-oauth|21561651    |      0       |     15     |
   +--------------------------------------------------------+
   */

   require_once APPLICATION_PATH.'model/User.php';

   class User_Mapper extends Mapper{

      public function __construct() {
         parent::__construct('users', 'User');
      }

      //returns Best 5 players
      public function getBest5() {
         $sql = "
         SELECT *
         FROM users
         ORDER BY score desc
         LIMIT 5
         ";
         return $this->_db->queryAll($sql, $this->_type);
      }
   }
?>
