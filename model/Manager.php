<?php
class Manager {
    protected $_db;

    CONST HOST = "localhost";
    CONST DBNAME = "hustleandgrind";
    CONST LOGIN = "root";
    CONST PWD = "";
    
    // constructor
    function __construct() {
        $host = self::HOST;
        $dbname = self::DBNAME;
        $this->_db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", self::LOGIN, self::PWD);
    }

    public function insertVote($userId,$answer) {       
    // public function insertVote($userId,$questionId,$answer) {
        // $insertVote = $this->_db->prepare("INSERT INTO members(userId, vote) VALUES(:userId, :answer)");     
        $insertVote = $this->_db->prepare("INSERT INTO members(userId, questionId, vote) VALUES(:userId, :questionId, :answer)");
        $insertVote->bindParam(':userId',$userId,PDO::PARAM_STR);
        // $insertVote->bindParam(':questionId',$username,PDO::PARAM_STR);
        $insertVote->bindParam(':answer',$answer,PDO::PARAM_STR);
        $status = $insertVote->execute();
        if (!$status) {
            throw new PDOException('Impossible to add the vote!');
        }
        $insertVote->closeCursor();
    } 
}