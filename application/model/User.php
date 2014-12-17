<?php
//User.php -- this user class will be used to store a name, _email and password of a user
class User extends Identifiable{
    private $_score;
    private $_accesslevel;

    public function __construct(){
    }

    //SETTERS
    public function setScore($score){
        $this->_score = $score;
    }

    public function setAccesslevel($accesslevel) {
        $this->_accesslevel = $accesslevel;
    }

    //GETTERS
    public function getAccesslevel() {
        if($this->_accesslevel != null){
            return $this->_accesslevel;
        }else{
            return 1;
        }
    }

    public function getScore() {
        if($this->_score != null){
            return $this->_score;
        }else{
            return 0;
        }
    }

    //Increments the rightanswers counters and adds the addition to score
    public function addScore($addition) {
        $this->_score+=$addition;
    }

    public function toArray() {
        $fields['id'] = $this->getID();
        $fields['accesslevel']= $this->getAccesslevel();
        $fields['score'] = $this->getScore();
        return $fields;
    }

    public function jsonSerialize(){
        return $this->toArray();
    }
}
?>