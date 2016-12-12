<?php

require_once(ROOT_PATH . 'base/dbInterface.php');

class SqlDatabase implements DBInterface{

    private $database;    //PDO object for database connection
    private $isConnected; //Boolean if successfully connected

    /**
    * __construct()
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
            $host = "mysql:host=${host}";
            if( isset($port) && $port !== '' ){
                $host_port = $host . ":${port}";
            }    
            $connectionString = $host . ";dbname=${dbname}" ;
            $this->database = new PDO ($connectionString, $username, $password);
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->isConnected = true;

        }   catch(PDOException $e)  {
            
            //Left unhandled; To be handled in model
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    /**
    * void closeConnection()
    * Closes PDO database connection by setting PDO object to NULL
    **/
    public function closeConnection(){
        $this->database = NULL;
        $this->isConnected = NULL;
    }


    /**
    * execQuery($query, $params, $fetchmode)
    *
    * @param string $query
    * @param array  $params
    * @param string $fetchmode
    * 
    * @return array
    * @return int
    * @return NULL
    *
    * Method prepares $query for execution, 
    * then bootstraps it with paramaters from $params argument,
    * and executes the query. 
    * Returns the query results if query is either select or show statement.
    * Returns number of rows affected if query is insert, update, or delete.
    * Returns NULL otherwise
    **/
    public function execQuery($query, $params = NULL, $fetchmode = PDO::FETCH_ASSOC){

        //Replace return carriage with blank space
        $query = trim(str_replace("\r", " ", $query));

        //Replace white spaces, tabs, and line feed characters with blank spaces
        $statementType = explode(" ", preg_replace("/\s+|\t+|\n+/", " ", $query))[0];

        //Prepare query
        $preparedQuery = $this->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try{
            //If an argument array of parameters for the query is provided
            if($params !== NULL && is_array($params)){
                //Execute query with argument array
                $preparedQuery->execute($params);
            } else {
                //Execute query without argumetn array
                $preparedQuery->execute();
            }
        
        }catch(PDOException $e){
            throw new Exception($e);
        }

        $statementType = strtolower($statementType);
        if ($statementType === 'select' || $statementType === 'show') {
            return $preparedQuery->fetchAll($fetchmode);
        } else if ($statementType === 'insert' || $statementType === 'update' || $statementType === 'delete') {
            return $preparedQuery->rowCount();
        } else {
            return NULL;
        }

    }

    /**
    * public function isConnected()
    * 
    * @return boolean $isConnected
    *
    * Returns the wether or not the database is connected.
    **/
    public function isConnected(){
        
        return $this->isConnected;
    }


    /**
    * __destruct()
    *
    * Closes database connection before destroying object.
    **/
    function __destruct(){
        
        $this->closeConnection();
    }


}

?>