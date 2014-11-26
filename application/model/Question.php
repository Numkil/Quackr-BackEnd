<?php
   //Question.php -- Question's that can be answered on the site.
   class Question extends Identifiable{
      private $_question;
      private $_answer;
      private $_possibilities;
      private $_level;
      private $_categoryid;

      public function __construct(){
         // body..
      }

      public function setId($id) {
         parent::setId($id);
         if($this->getPossibilities() != null){
            foreach($this->getPossibilities() as $value){
               $value->setId($this->getId());
            }
         }
      }

      public function setQuestion($question) {
         $this->_question = $question;
      }

      public function setCategoryId($id) {
         $this->_categoryid = $id;
      }

      public function setAnswer($answer) {
         $this->_answer = $answer;
      }

      /*The record where the "correct" value is true is the right answer.
      this record will be passed to setAnswer
      Every available record's proposal value will be added to the list of possibilities n*/
      public function setPossibilities($possibilities = array()) {
         foreach($possibilities as $value) {
            if ($value->getCorrect() == true) {
               $this->setAnswer($value->getPropanswer());
            }
         }
         $this->_possibilities = $possibilities;
      }

      public function setLevel($lvl) {
         $this->_level = $lvl;
      }

      //GETTERS
      public function getQuestion(){
         return $this->_question;
      }

      public function getAnswer() {
         return $this->_answer;
      }

      public function getCategoryId() {
         return $this->_categoryid;
      }

      public function getPossibilities(){
         return $this->_possibilities;
      }

      public function getLevel() {
         return $this->_level;
      }

      public function getType(){
         if(sizeof($this->getPossibilities()) > 1){
            return "MultipleChoice";
         }else{
            return "Open Question";
         }
      }

      public function toArray() {
         $fields['question'] = $this->getQuestion();
         $fields['lvl'] = $this->getLevel();
         $fields['categoryid'] = $this->getCategoryId();
         return $fields;
      }
   }
?>