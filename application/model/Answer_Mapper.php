<?php
   /*Answer_Mapper.php -- Implements the specific code for adding/retrieving a question from DB
   Uses DB.php->execute method for server contact

   answers table layout for future reference
   +-----------------------------------------+
   | questionlink |    propanswer  | correct |
   +-----------------------------------------+
   |       1      |    Super cool  |    t    |
   +-----------------------------------------+
    */

require_once APPLICATION_PATH.'model/Answer.php';

class Answer_Mapper extends Mapper{

    public function __construct(){
        parent::__construct('answers', 'Answer');
    }
}

?>