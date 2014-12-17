<?php
   /*Answer_Mapper.php -- Implements the specific code for adding/retrieving a question from DB
   Uses DB.php->execute method for server contact
   answers table layout for future reference
   +-------------------------------------------------+
   | questionlink |    userlink    | correctAnswered |
   +-------------------------------------------------+
   |       1      |  google|25452  |         t       |
   +-------------------------------------------------+
    */

require_once APPLICATION_PATH.'model/AnsweredQuestions.php';

class AnsweredQuestions_Mapper extends Mapper{

    public function __construct(){
        parent::__construct('answeredquestions', 'AnsweredQuestions');
    }

    public function size($userid, $categoryid=null){
        if($categoryid){
            $query= "
                SELECT count(*)
                FROM $this->_table inner join questions on questions.id = questionlink
                where userlink = :userlink and categoryid = :categoryid
                ";
            return $this->_db->primitiveQuery($query, array('userlink'=>$userid,'categoryid'=> $categoryid));
        }else{
            $query = "
                SELECT count(*)
                FROM $this->_table
                where userlink = ?
                ";
            return $this->_db->primitiveQuery($query, $userid);
        }
    }
}

?>