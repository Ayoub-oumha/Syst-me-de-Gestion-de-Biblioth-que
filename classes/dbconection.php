<?php

class Database2 {
    private $local = "localhost" ;
    private $dbname ;
    private $username ;
    private $password ;
    private $host ;
    private $connection ;
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    public function __construct($dbname , $username , $password , $host = null)
    {
        $this->dbname = $dbname;
        $this->username = $username ;
        $this->password = $password;
        if($host){
            $this->host = $host;
        }
    }
    public function connect(){
        try {
              $dsn = "mysql:local={$this->local};dbname={$this->dbname}" ;
        $this->connection = new PDO($dsn , $this->username , $this->password , $this->options) ;
        // echo "good you are connect to db " ;
        return true ;
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function query($sql){
        try{
           
            $stmt = $this->connection->query($sql);
            $fetch = $stmt->fetchAll(PDO::FETCH_OBJ) ;
            return $fetch ;
             
        }
        catch (PDOException $e){
            echo "error in query" ;
        }

    }
    // public function prepareAndExcute($sql){
    //     $pre = $this->connection->prepare($sql) ;
    //     $exc = $pre->excute() ;
    // }
    public function prepareAndExecute($sql, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            echo "error in prepare and execute: " . $e->getMessage();
        }
    }
};
