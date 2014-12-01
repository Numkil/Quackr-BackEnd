<?php
   /*Question_Mapper.php -- Implements the specific code for adding/retrieving a question from DB
   Uses DB.php->execute method for server contact

   questions table layout for future reference
   +------------------------------+
   | id |    question    | reward |
   +-------------------------- ---+
   |  1 | how cool am I? |    4   |
   +----------------------------- +

   */

   require_once APPLICATION_PATH.'model/Answer_Mapper.php';
   require_once APPLICATION_PATH.'model/Answer.php';
   require_once APPLICATION_PATH.'model/Question.php';

   class Question_Mapper extends Mapper{
      private $_answermapper;

      public function __construct() {
         parent::__construct('questions', 'Question');
         $this->_answermapper = new Answer_Mapper();
      }

      private function getRandom($id, $categoryid){
         $query = "
         select *from questions inner join categories on categories.id = categoryid
            where questions.id not in(
            SELECT questions.id
            from answeredquestions inner join questions on id = questionlink where userlink = ?)
            AND categories.id = ?
            order by rand() limit 1
            ";
            return $this->_db->queryOne($query, $this->_type, array($id, $categoryid));
         }

         public function getRandomQuestion($id, $categoryid){
            //get the corresponding Question from DB
            $question = $this->getRandom($id, $categoryid);
            //get the corresponding answers
            if($question == null){
               return false;
            }
            $answers = $this->_answermapper->getAllWithArgument($question->getId(), 'questionlink');
            $question->setPossibilities($answers);
            return $question;
         }

         public function add($object){
            $id = parent::add($object);
            if($id){
               $object->setId($id);
            }
            foreach($object->getPossibilities() as $value){
               $this->_answermapper->add($value);
            }
         }

         public function get($id, $idname = 'id'){
            $question = parent::get($id, $idname);
            $answers = $this->_answermapper->getAllWithArgument($id, 'questionlink');
            $question->setPossibilities($answers);
            return $question;
         }

         public function updateQuestion($object){
            parent::update($object);
            $fields['questionlink'] = $object->getId();
            $this->_answermapper->delete($fields);
            foreach($object->getPossibilities() as $value){
               $this->_answermapper->add($value);
            }
         }

         public function getAllFromCategory($argument) {
            $questions = parent::getAllWithArgument($argument, 'categoryid');
            foreach ($questions as $question){
               $answers = $this->_answermapper->getAllWithArgument($question->getID(), 'questionlink');
               $question->setPossibilities($answers);
            }
            return $questions;
         }
      }
   ?>
