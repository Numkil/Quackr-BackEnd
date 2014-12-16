<?php
   /**
   * Class QuestionController
   * Mainly used for checking whether it is the first time
   * this user has visited our app
   */
   require_once(APPLICATION_PATH.'model/AnsweredQuestions_Mapper.php');
   class AnsweredQuestionsController extends Controller
   {
      private $_answerdquestionsmapper;

      public function __construct()
      {
         parent::__construct();
         $this->_answerdquestionsmapper = new AnsweredQuestions_Mapper();
      }

      public function registerAnswers($userid){
         $json = file_get_contents('php://input');
         $jsondecoded = json_decode($json);
         foreach ($jsondecoded->wrong as $value){
            $value = $this->_sanitizer->sanitize($value);
            $answqstn = new AnsweredQuestions();
            $answqstn->setQuestionlink($value);
            $answqstn->setUserlink($userid);
            $answqstn->setCorrectAnswered(0);
            $this->_answerdquestionsmapper->add($answqstn);
         }
         foreach ($jsondecoded->correct as $value){
            $value = $this->_sanitizer->sanitize($value);
            $answqstn = new AnsweredQuestions();
            $answqstn->setQuestionlink($value);
            $answqstn->setUserlink($userid);
            $answqstn->setCorrectAnswered(1);
            $this->_answerdquestionsmapper->add($answqstn);
         }
      }

      public function resetProgress($userid){
         $this->_answerdquestionsmapper->delete($userid, 'userlink');
      }

   }
?>
