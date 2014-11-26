<?php
   /*Category_Mapper.php -- Implements the specific code for adding/retrieving a category from DB
   Uses DB.php->execute method for server contact

   categories table layout for future reference
   +-----------------------------------+
   |        id    |    categoryname    |
   +-----------------------------------+
   |       1      |     trivia         |
   +-----------------------------------+ 
   */

   require_once APPLICATION_PATH. 'model/Category.php';

   class Category_Mapper extends Mapper{

      public function __construct(){
         parent::__construct('categories', 'Category');
      }
   }

?>