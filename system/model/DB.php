<?php
   //DB.php -- This is a requirement for all MAPPERS
   //It will do all the generic shit for them.
   class DB{
      private static $instance = null;
      private $_db;

      //reads all the info from config.php and sets up a basic connection with the server.
      private function __construct(){
         //Pull out the driver related code and put them in string $dsn
         global $db_config;
         $dsn = $db_config['driver']. ':';
         foreach ($db_config['dsn'] as $key => $value) {
            $dsn .= $key . '=' . $value . ';';
         }
         //Attempt to let the PDO establish a connection with the string $dsn and a username and password
         try{
            $this->_db = new PDO($dsn, $db_config['username'], $db_config['password']);
            $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if (($db_config['driver'] == 'pgsql') && isset($db_config['schema'])) {
               $this->_db->query(sprintf("SET SEARCH_PATH TO %s", $db_config['schema']));
            }
         }catch (PDOException $e){
            error_log($e->getMessage(), 0);
         }
      }

      //Implements the Singleton pattern
      public static function getInstance() {
         if(!self::$instance){
            self::$instance = new self();
         }
         return self::$instance;
      }

      public function execute($sql, $arguments = array())
      {
         if (!is_array($arguments)) {
            $arguments = array($arguments);
         }
         try {
            $stmt = $this->_db->prepare($sql);
            $stmt->execute($arguments);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
         } catch(PDOException $e) {
            error_log($e->getMessage());
         }
         return $stmt;
      }

      public function queryAll($sql, $type, $arguments = array())
      {
         $stmt = $this->execute($sql, $arguments);
         return $stmt->fetchAll(PDO::FETCH_CLASS, $type);
      }

      public function queryOne($sql, $type, $arguments = array())
      {
         $stmt = $this->execute($sql, $arguments);
         //TODO FIGURE OUT HOW I can get the inserted row back
         $stmt->fetchObject($type);
      }

      //Change the way it returns the given data;
      public function primitiveQuery($sql) {
         $stmt = $this->execute($sql);
         return $stmt->fetch(PDO::FETCH_LAZY);
      }
   }

?>
