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

      private function _sortArrayOfQuestions($questions){
         $container = array();
         foreach ($questions as $question){
            $level = array();
            foreach ($questions as $innerquestion){
               if($question->getLvl() == $innerquestion->getLvl()){
                  array_push($level, $innerquestion);
               }
            }
            array_merge($container, $level);
         }
         return $container;
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

      public function getRandom($categoryid, $userid){
         $categoryid = $this->_sanitizer->sanitize($categoryid);
         $category = $this->_categorymapper->get($categoryid, 'id');
         $question = $this->_questionmapper->getRandomQuestion($userid, $categoryid);
         $category->questioncontainer = $question->jsonSerialize();
         echo(json_encode($category->jsonSerialize()));
      }

      public function getMultipleRandoms($categoryid, $userid, $amount){
         $categoryid = $this->_sanitizer->sanitize($categoryid);
         $amount = $this->_sanitizer->sanitize($amount);
         $category = $this->_categorymapper->get($categoryid, 'id');
         $questions = $this->_questionmapper->getRandomQuestions($userid, $categoryid, $amount);
         $container = $this->_sortArrayOfQuestions($questions);
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
         $categoryid = $this->_sanitizer->sanitize($categoryid);
         $sizeQuestions = $this->_questionmapper->size($categoryid);
         $sizeFinished = $this->_answerdquestionsmapper->size($userid, $categoryid);
         $sizeFinished = ($sizeFinished ? $sizeFinished : "0");
         echo("{\"sizeFinished\":".$sizeFinished.", \"sizeQuestions\":".$sizeQuestions."}");
      }
   }
?>
