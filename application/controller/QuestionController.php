<?php
   /**
   * Class QuestionController
   * Mainly used for checking whether it is the first time
   * this user has visited our app
   */
   require_once(APPLICATION_PATH.'model/Question_Mapper.php');
   require_once(APPLICATION_PATH.'model/Answer_Mapper.php');
   require_once(APPLICATION_PATH.'model/Category_Mapper.php');
   class QuestionController extends Controller
   {
      private $_questionmapper;
      private $_answermapper;
      private $_categorymapper;

      public function __construct($id)
      {
         parent::__construct();
         $this->_questionmapper = new Question_Mapper();
         $this->_answermapper = new Answer_Mapper();
         $this->_categorymapper = new Category_Mapper();
      }

      public function getAllCategories(){
         $categories = $this->_categorymapper->getAll();
         echo(json_encode($output));
      }
   }
?>
