<?php
   //Answer.php -- Answer's objects are used by a Question object to store and keep track of the possible answers
   class Answer extends Identifiable{
      private $_propanswer;
      private $_correct;

      public function __construct() {
         // body...
      }

      public function setPropanswer($argument) {
         $this->_propanswer = $argument;
      }

      public function setCorrect($argument) {
         $this->_correct = $argument;
      }

      public function getPropanswer() {
         return $this->_propanswer;
      }

      public function getCorrect() {
         if($this->_correct){
            return true;
         }else{
            return 0;
         }
      }

      public function toArray(){
         $fields['Questionlink'] = $this->getId();
         $fields['propanswer'] = $this->getPropAnswer();
         $fields['correct'] = $this->getCorrect();
         return $fields;
      }

   }
?>