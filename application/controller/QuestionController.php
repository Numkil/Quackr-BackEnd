<?php
   /**
   * Class QuestionController
   * Mainly used for checking whether it is the first time
   * this user has visited our app
   */
   require_once(APPLICATION_PATH.'model/Question_Mapper.php');
   require_once(APPLICATION_PATH.'model/Answer_Mapper.php');
   require_once(APPLICATION_PATH.'model/Category_Mapper.php');
   require_once(APPLICATION_PATH.'model/AnsweredQuestions_Mapper.php');
   class QuestionController extends Controller
   {
      private $_questionmapper;
      private $_answermapper;
      private $_categorymapper;
      private $_answerdquestionsmapper;

      public function __construct()
      {
         parent::__construct();
         $this->_questionmapper = new Question_Mapper();
         $this->_answermapper = new Answer_Mapper();
         $this->_categorymapper = new Category_Mapper();
         $this->_answerdquestionsmapper = new AnsweredQuestions_Mapper();
      }

      public function getAllCategories(){
         $categories = $this->_categorymapper->getAll();
         $i = 0;
         $container = array();
         foreach ($categories as $category){
            $container[$i] = $category->jsonSerialize();
            $i++;
         }
         echo(json_encode($container));
      }

      public function getQuestionsFromCategory($categoryid){
         $category = $this->_categorymapper->get($categoryid, 'id');
         $questions = $this->_questionmapper->getAllFromCategory($categoryid);
         $i = 0;
         $container = array();
         foreach ($questions as $question){
            $container[$i] = $question->jsonSerialize();
            $i++;
         }
         $category->questioncontainer = $container;
         echo(json_encode($category->jsonSerialize()));
      }

      public function getQuestion($questionid){
         $question = $this->_questionmapper->get($questionid);
         echo(json_encode($question->jsonSerialize()));
      }


      public function getRandom($categoryid, $userid){
         $category = $this->_categorymapper->get($categoryid, 'id');
         $question = $this->_questionmapper->getRandomQuestion($userid, $categoryid);
         $category->questioncontainer = $question->jsonSerialize();
         echo(json_encode($category->jsonSerialize()));
      }

      public function getMultipleRandoms($categoryid, $userid, $amount){
         $category = $this->_categorymapper->get($categoryid, 'id');
         $questions = $this->_questionmapper->getRandomQuestions($userid, $categoryid, $amount);
         $i = 0;
         $container = array();
         foreach ($questions as $question){
            $container[$i] = $question->jsonSerialize();
            $i++;
         }
         $category->questioncontainer = $container;
         echo(json_encode($category->jsonSerialize()));
      }

      public function getSizeAnswered($userid){
         $sizeQuestions = $this->_questionmapper->size();
         $sizeFinished = $this->_answerdquestionsmapper->size($userid);
         $sizeFinished = ($sizeFinished ? $sizeFinished : "0");
         echo("{\"sizeFinished\":".$sizeFinished.", \"sizeQuestions\":".$sizeQuestions."}");
      }

      public function getSizeAnsweredFromCategory($userid, $categoryid){
         $sizeQuestions = $this->_questionmapper->size($categoryid);
         $sizeFinished = $this->_answerdquestionsmapper->size($userid, $categoryid);
         $sizeFinished = ($sizeFinished ? $sizeFinished : "0");
         echo("{\"sizeFinished\":".$sizeFinished.", \"sizeQuestions\":".$sizeQuestions."}");
      }
   }
?>
