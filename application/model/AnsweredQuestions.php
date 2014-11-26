<?php
   class AnsweredQuestions extends Identifiable{
      private $_userlink;
      private $_questionlink;

      public function __construct() {
         // body...
      }

      public function setUserlink($argument) {
         $this->_userlink = $argument;
      }

      public function setQuestionlink($argument) {
         $this->_questionlink = $argument;
      }

      public function getUserlink() {
         return $this->_userlink;
      }

      public function getQuestionlink() {
         return $this->_questionlink;
      }

      public function toArray(){
         $fields['Userlink'] = $this->getUserlink();
         $fields['Questionlink'] = $this->getQuestionlink();
         return $fields;
      }
   }
?>