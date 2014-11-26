<?php

   class Input
   {

      public function sanitize($value, $default = false)
      {
         if ($value) {
            return $this->_sanitize($value);
         } else {
            return $default;
         }
      }

      private function _sanitize($input)
      {
         if (is_array($input)) {
            for ($i = 0; $i < count($input); $i++) {
               $this->_sanitize($input[$i]);
            }
         } else {
            $input = trim($input);
            $input = htmlentities($input, ENT_QUOTES, "UTF-8");
         }

         return $input;
      }
   }
?>