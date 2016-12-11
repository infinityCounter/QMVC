<?php

class SqlDatabase implements DBInterface{

    private $database;    //PDO object for database connection
    private $isConnected; //Boolean if successfully connected

    /**
    * Construct of SqlDatabase class instance 
    * Connect to sql database using PDO
    * @param string $host
    * @param int    $port
    * @param string $dbname
    * @param string $username
    * @param string $password
    **/

    function __construct($host, $port, $dbname, $username, $password){

        try{

            $this->database = new PDO ("dblib:host=$host:$port;dbname=$this->dbname", "$this->username", "$this->pwd");
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->isConnected = true;

        }   catch(PDOException $e)  {
            
            //Left unhandled; To be handled in model
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function closeConnection(){
        # Set the PDO object to null to close the connection
        $this->database = null;
        $this->isConnected = null;
    }

    public function execQuery($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){

        $query = trim(str_replace("\r", " ", $query));
        $statementType = explode(" ", preg_replace("/\s+|\t+|\n+/", " ", $query))[0];
        $preparedQuery = $this->database->prepare($query);
        try{
            if($params !== null && is_array(params)){
                $preparedQuery->execute($params);
            } else {
                $preparedQuery->execute();
            }
        
        }catch(PDOException $e){
            throw new Exception($e);
        }

        if ($statementType === 'select' || $statementType === 'show') {
            return $preparedQuery->fetchAll($fetchmode);
        } else if ($statementType === 'insert' || $statementType === 'update' || $statementType === 'delete') {
            return $preparedQuery->rowCount();
        } else {
            return NULL;
        }

    }

    public function isConnected(){
        
        return $this->isConnected;
    }


    function __destruct(){
        
        $this->closeConnection();
    }


}

?>