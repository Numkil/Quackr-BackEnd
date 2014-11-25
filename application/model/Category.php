<?php
   //Category.php
   class Category extends Identifiable {
      private $_categoryname;

      public function setCategoryName($argument)
      {
         $this->_categoryname = $argument;
      }

      public function getCategoryName(){
         return $this->_categoryname;
      }

      public function toArray(){
         $fields['categoryname'] = $this->getCategoryName();
         return $fields;
      }

   }

?>
