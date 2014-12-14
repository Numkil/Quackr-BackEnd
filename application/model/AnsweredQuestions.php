<?php
   class AnsweredQuestions extends Identifiable{
      private $_userlink;
      private $_questionlink;
      private $_correctanswered;

      public function __construct() {
         // body...
      }

      public function setUserlink($argument) {
         $this->_userlink = $argument;
      }

      public function setCorrectAnswered($argument){
         $this->_correctanswered = $argument;
      }

      public function setQuestionlink($argument) {
         $this->_questionlink = $argument;
      }

      public function getUserlink() {
         return $this->_userlink;
      }

      public function getCorrectAnswered(){
         if($this->_correctanswered){
            return 1;
         }else{
            return 0;
         }
      }

      public function getQuestionlink() {
         return $this->_questionlink;
      }

      public function toArray(){
         $fields['userlink'] = $this->getUserlink();
         $fields['questionlink'] = $this->getQuestionlink();
         $fields['correctAnswered'] = $this->getCorrectAnswered();
         return $fields;
      }

      public function jsonSerialize(){
         return $this->toArray();
      }
   }
?>
