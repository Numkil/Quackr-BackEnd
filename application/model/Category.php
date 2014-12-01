<?php
   //Category.php
   class Category extends Identifiable {
      private $_categoryname;
      public $questioncontainer;

      public function setCategoryName($argument)
      {
         $this->_categoryname = $argument;
         $this->questioncontainer = array();
      }

      public function getCategoryName(){
         return $this->_categoryname;
      }

      public function toArray(){
         $fields['categoryname'] = $this->getCategoryName();
         return $fields;
      }

      public function toRecursiveArray(){
         $fields['categoryname'] = $this->getCategoryName();
         $fields['id'] = $this->getID();
         $fields['questions'] = $this->questioncontainer;
         return $fields;
      }
   }

?>
