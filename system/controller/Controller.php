<?php

   /**
   * @author Numkil
   */
   class Controller
   {
      protected $_sanitizer;

      public function __construct()
      {
         $this->_sanitizer = new Input();
      }

      protected function _hasRequiredAccesLevel($user, $requiredAccessLevel){
         if($user->getAccesslevel() >= $requiredAccessLevel){
            return true;
         }else{
            header('HTTP/1.0 401 Unauthorized');
            echo "User has not enough rights for this function";
            //Discuss: hard exit here because we know already you are not allowed?
            return false;
         }
      }
   }

?>
