<?php
   /*Answer_Mapper.php -- Implements the specific code for adding/retrieving a question from DB
   Uses DB.php->execute method for server contact
   */

   require_once APPLICATION_PATH.'model/AnsweredQuestions.php';

   class AnsweredQuestions_Mapper extends Mapper{

      public function __construct(){
         parent::__construct('answeredquestions', 'AnsweredQuestions');
      }
   }

?>
