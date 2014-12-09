<?php
   require_once(SYSTEM_PATH . 'model/DB.php');

   class Mapper
   {
      protected $_db;
      protected $_table;
      protected $_type;

      public function __construct($table, $type)
      {
         $this->_db = Db::getInstance();
         $this->_table = $table;
         $this->_type = $type;
      }

      public function get($id, $idname)

      {
         $query = "
         SELECT *
         FROM $this->_table
         WHERE $idname = ?;
         ";
         return $this->_db->queryOne($query, $this->_type, array($id));
      }

      public function size(){
         $query = "
         SELECT count(*)
         FROM $this->_table
         ";
         return $this->_db->primitiveQuery($query);
      }

      public function getAllWithArgument($argument, $argumentname) {
         $query = "
         SELECT *
         FROM $this->_table
         WHERE $argumentname = ?;
         ";
         return $this->_db->queryAll($query, $this->_type, array($argument));
      }

      public function getAll()
      {
         $query = "
         SELECT *
         FROM $this->_table
         ";
         return $this->_db->queryAll($query, $this->_type);
      }

      public function add($object)
      {
         $values = $object->toArray();
         $fieldNames = array_keys($values);
         $queryArguments = $this->createQueryArguments($values);
         $query = "INSERT INTO $this->_table (" . implode(', ', $fieldNames) . ") VALUES (:" . implode(', :', $fieldNames) . ")";
         $result = $this->_db->add($query, $queryArguments);
         if($result){
            $object->setID($result);
         }
         return $object;
      }

      public function update($object, $where = array())
      {
         $values = $object->toArray();
         // fallback voor als er geen where is meegegeven: where op basis van de id
         if (!$where) {
            $where = array(
               'id' => $object->getId()
            );
         }
         $fieldNames = $this->createFieldnames($values);
         $wherefields = $this->createWhereFields($where);
         $queryArguments = $this->createWhereArguments($where) + $this->createQueryArguments($values);
         $query = "
         UPDATE $this->_table
         SET " . implode(', ', $fieldNames) . "
         WHERE " . implode(' AND ', $wherefields) . "
         ";
         $this->_db->execute($query, $queryArguments);
      }

      public function delete($where = array())
      {
         if (!is_array($where)) {
            $where = array(
               'id' => $where
            );
         }
         $wherefields = $this->createWhereFields($where);
         $queryArguments = $this->createWhereArguments($where);
         $query = "
         DELETE
         FROM $this->_table
         WHERE " . implode(' AND ', $wherefields) . "
         ";
         $this->_db->execute($query, $queryArguments);
      }

      private function createFieldnames($values)
      {
         $fieldNames = array();
         foreach ($values as $fieldname => $value) {
            $fieldNames[] = "$fieldname = :$fieldname";
         }
         return $fieldNames;
      }

      private function createWhereFields($where)
      {
         $whereFields = array();
         foreach ($where as $key => $value) {
            $whereFields[] = "$key = :w_$key";
         }
         return $whereFields;
      }

      private function createQueryArguments($values)
      {
         $queryArguments = array();
         foreach ($values as $key => $value) {
            $queryArguments[':' . $key] = $value;
         }
         return $queryArguments;
      }

      private function createWhereArguments($where)
      {
         $whereArguments = array();
         foreach ($where as $key => $value) {
            $whereArguments[':w_' . $key] = $value;
         }
         return $whereArguments;
      }
   }
