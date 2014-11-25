<?php
   /**
   * Class UserController
   * Mainly used for checking whether it is the first time
   * this user has visited our app
   */
   require_once(APPLICATION_PATH.'model/User_Mapper.php');
   class UserController extends Controller
   {
      private $_usermapper;
      private $_id;

      public function __construct($id)
      {
         parent::__construct();
         $this->_usermapper = new User_Mapper();
         $this->_id = $this->_sanitizer->sanitize($id);
      }

      /*
      Check whether ID is present in database
      */
      public function exists()
      {
         $tempuser = $this->_usermapper->get($this->_id, 'id');
         if($tempuser){
            return true;
         }else{
            return false;
         }
      }

      /*
      Push the userid to our database
      */
      public function register(){
         $user = new User();
         if($id && !$this->exists($id)){
            $user->setID($this->_id);
            $this->_usermapper->add($user);
            return true;
         }
         return false;
      }

      /*
      Perform authorization check for this particular user
      */
      public function checkAuthorization($requiredAccessLevel){
         $tempuser = $this->_usermapper->get($this->_id, 'id');
         return $this->_hasRequiredAccesLevel($requiredAccessLevel);
      }

   }
?>
