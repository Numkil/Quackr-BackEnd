<?php
   //Make constants to save some typing work
   define('APPLICATION_PATH', 'application/');
   define('SYSTEM_PATH', 'system/');
   $UserController;

   // Require composer autoloader
   require_once __DIR__ . '/vendor/autoload.php';
   require_once '.db_password.php';
   require_once SYSTEM_PATH.'model/DB.php';
   require_once SYSTEM_PATH.'model/Identifiable.php';
   require_once SYSTEM_PATH.'model/Mapper.php';
   require_once SYSTEM_PATH.'controller/Input.php';
   require_once SYSTEM_PATH.'controller/Controller.php';
   require_once APPLICATION_PATH.'controller/UserController.php';
   require_once APPLICATION_PATH.'controller/QuestionController.php';
   require_once APPLICATION_PATH.'config.php';

   // In case one is using PHP 5.4's built-in server
   $filename = __DIR__ . preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
   if (php_sapi_name() === 'cli-server' && is_file($filename)) {
      return false;
   }

   if( !function_exists('apache_request_headers') ) {

      function apache_request_headers() {
         $arh = array();
         $rx_http = '/\AHTTP_/';
         foreach($_SERVER as $key => $val) {
            if( preg_match($rx_http, $key) ) {
               $arh_key = preg_replace($rx_http, '', $key);
               $rx_matches = array();
               // do some nasty string manipulations to restore the original letter case
               // this should work in most cases
               $rx_matches = explode('_', $arh_key);
               if( count($rx_matches) > 0 and strlen($arh_key) > 2 ) {
                  foreach($rx_matches as $ak_key => $ak_val) $rx_matches[$ak_key] = ucfirst($ak_val);
                  $arh_key = implode('-', $rx_matches);
               }
               $arh[$arh_key] = $val;
            }
         }
         return( $arh );
      }
   }

   // Read .env
   try {
      Dotenv::load(__DIR__);
   } catch(InvalidArgumentException $ex) {
      // Ignore if no dotenv
   }

   // Create Router instance
   $router = new \Bramus\Router\Router();

   // Activate CORS
   function setCorsHeaders() {
      header("Access-Control-Allow-Origin: *");
      header("Access-Control-Allow-Headers: Authorization");
      header("Access-Control-Allow-Methods: GET,HEAD,PUT,PATCH,POST,DELETE");
   }
   $router->options('/.*', function() {
      setCorsHeaders();
   });
   setCorsHeaders();


   // Check JWT on /secured routes
   $router->before('GET', '/secured/.*', function() {
      global $ID;
      global $UserController;

      //BEFORE verification of login
      $requestHeaders = apache_request_headers();
      $authorizationHeader = $requestHeaders['Authorization'];

      if ($authorizationHeader == null) {
         header('HTTP/1.0 401 Unauthorized');
         echo "No authorization header sent";
         exit();
      }

      // // validate the token
      $token = str_replace('Bearer ', '', $authorizationHeader);
      $secret = getenv('AUTH0_CLIENT_SECRET');
      $decoded_token = null;
      try {
         $decoded_token = JWT::decode($token, base64_decode(strtr($secret, '-_', '+/')) );
      } catch(UnexpectedValueException $ex) {
         header('HTTP/1.0 401 Unauthorized');
         echo "Invalid token";
         exit();
      }

      // // validate that this token was made for us
      if ($decoded_token->aud != getenv('AUTH0_CLIENT_ID')) {
         header('HTTP/1.0 401 Unauthorized');
         echo "Invalid token";
         exit();
      }

      //AFTER verification of login
      $UserController = new UserController($requestHeaders['ID']);
      $UserController->register();
   });

   //Testing purposes only
   $router->match('GET¡POST', '/ping', function() {
      echo "All good. You don't need to be authenticated to call this";
   });

   //Testing purposes only
   $router->match('GET¡POST', '/secured/ping', function() {
      echo "All good. You only get this message if you're authenticated";
   });

   //RETURNS all Categories
   $router->get('/secured/categories', function() {
      $questioncontroller = new QuestionController();
      $questioncontroller->getAllCategories();
   });

   //RETURNS Questions from category
   $router->get('/secured/category/(\d+)', function($categoryid){
      $questioncontroller = new QuestionController();
      $questioncontroller->getQuestionsFromCategory($categoryid);
   });

   //RETURNS random question which has not been answered by the user
   $router->get('/secured/category/(\d+)/random', function($categoryid){
      $questioncontroller = new QuestionController();
      global $UserController;
      $questioncontroller->getRandom($categoryid, $UserController->getId());
   });

   //RETURNS several random questions as specified in url, less if there aren't enough unanswered
   //questions by the user
   $router->get('/secured/category/(\d+)/random/(\d+)/', function($categoryid, $amount){
      $questioncontroller = new QuestionController();
      global $UserController;
      $questioncontroller->getMultipleRandoms($categoryid, $UserController->getId(), $amount);
   });

   //RETURNS 1 specific question
   $router->get('/secured/question/(\d+)', function($questionid){
      $questioncontroller = new QuestionController();
      $questioncontroller->getQuestion($questionid);
   });

   //RETURN information about the current user
   $router->get('/secured/user/info', function($questionid){
      global $UserController;
      $UserController->getCurrentUser();
   });

   //None of the above categories matched
   $router->set404(function() {
      header('HTTP/1.1 404 Not Found');
      echo "Page not found";
   });

   // Run the Router
   $router->run();
?>
