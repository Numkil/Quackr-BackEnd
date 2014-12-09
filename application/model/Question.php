<?php
   //Question.php -- Question's that can be answered on the site.
   class Question extends Identifiable{
      private $_question;
      private $_answers;
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

      public function setAnswers($answer = array()) {
         $this->_answers = $answer;
      }

      /*The record where the "correct" value is true is the right answer.
      this record will be passed to setAnswer
      Every available record's proposal value will be added to the list of possibilities n*/
      public function setPossibilities($possibilities = array()) {
         $correctanswers = array();
         foreach($possibilities as $value) {
            if ($value->getCorrect() == 1) {
               array_push($correctanswers, $value);
            }
         }
         $this->setAnswers($correctanswers);
         $this->_possibilities = $possibilities;
      }

      public function setLvl($lvl) {
         $this->_level = $lvl;
      }

      //GETTERS
      public function getQuestion(){
         return $this->_question;
      }

      public function getAnswers() {
         return $this->_answers;
      }

      public function getCategoryId() {
         return $this->_categoryid;
      }

      public function getPossibilities(){
         return $this->_possibilities;
      }

      public function getLvl() {
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
         $fields['lvl'] = $this->getLvl();
         $fields['categoryid'] = $this->getCategoryId();
         return $fields;
      }

      public function jsonSerialize(){
         $fields['id'] = $this->getId();
         $fields['question'] = $this->getQuestion();
         $fields['lvl'] = $this->getLvl();
         $correctanswers = array();
         $i = 0;
         foreach ($this->getAnswers() as $answer){
            $correctanswers[$i] = $answer->jsonSerialize();
            $i++;
         }
         $fields['correctanswer'] = $correctanswers;
         $propanswers = array();
         $i = 0;
         foreach ($this->getPossibilities() as $propanswer){
            $propanswers[$i] = $propanswer->jsonSerialize();
            $i++;
         }
         $fields['propanswers'] = $propanswers;
         return $fields;
      }
   }
?>
