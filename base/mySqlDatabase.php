<?php

require_once(ROOT_PATH . 'base/dbInterface.php');
/*
* Class MySqlDatabase
*
* SQL database handler class; implements the methods defined by DBInterface
* Connects to both MySQL databases
*/
class MySqlDatabase implements DBInterface
{
    private $database;    //PDO object for database connection
    private $isConnected; //Boolean if successfully connected

    /**
    * Class constructor
    * Intializes an MySQL database connection with arguments given.
    *
    * @param string The hostname where the database is
    * @param int    Port on host to connect to
    * @param string Name of the database being connected to
    * @param string Username to connect to the database
    * @param string Password to connect to the database
    **/

    function __construct($host, $port, $dbname, $username, $password)
    {
        try{
            //Use the PDO_MYSQL driver: http://php.net/manual/en/ref.pdo-mysql.php
            $host = "mysql:host=${host}";
            if ( isset($port) && $port !== '' ){

                $host_port = $host . ":${port}";
            }    
            $connectionString = $host . ";dbname=${dbname}" ;
            //Connect to database
            $this->database = new PDO ($connectionString, $username, $password);
            //Throw PDO exceptions when error ooccur
            $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->isConnected = true;

        }   catch (PDOException $e){
            //Left unhandled; To be handled in model
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    /**
    * public function closeConnection
    *
    * Closes PDO database connection by setting PDO object to null
    *
    * @return void
    **/
    public function closeConnection()
    {
        $this->database = null;
        $this->isConnected = null;
    }


    /**
    * pubilc function execQuery
    *
    * Prepares and executes $query, using $params as arguments, and returns results of query.
    * @param string The string query to be executed using :identifier to identify locations to place arguments
    * @param array  Arguments to be added to query
    * @param string The mode to return query result object as either associated array or obejct
    * 
    * @return array | int | null Returns array of row results if SELECT or SHOW statment, and number of rows modified if UPDATE or DELETE 
    **/
    public function execQuery($query, $params = null, $fetchmode = PDO::FETCH_ASSOC)
    {
        //Replace return carriage with blank space
        $query = trim(str_replace("\r", " ", $query));

        //Replace white spaces, tabs, and line feed characters with blank spaces
        $statementType = explode(" ", preg_replace("/\s+|\t+|\n+/", " ", $query))[0];

        //Prepare query
        $preparedQuery = $this->database->prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        try{
            //If an argument array of parameters for the query is provided
            if ($params !== null && is_array($params)){
                //Execute query with argument array
                $preparedQuery->execute($params);
            } else {
                //Execute query without argumetn array
                $preparedQuery->execute();
            }
        
        }catch (PDOException $e){
            throw new Exception($e);
        }

        $statementType = strtolower($statementType);
        if ($statementType === 'select' || $statementType === 'show') {
            
            return $preparedQuery->fetchAll($fetchmode);
        } else if ($statementType === 'insert' || $statementType === 'update' || $statementType === 'delete') {
            
            return $preparedQuery->rowCount();
        } else {
            
            return null;
        }

    }

    /**
    * public function isConnected
    * 
    * @return boolean Boolean indicating if there is a current active database connection
    */
    public function isConnected()
    {   
        return $this->isConnected;
    }


    /**
    * Class destructor 
    *
    * Closes database connection before destroying object.
    **/
    function __destruct()
    {    
        $this->closeConnection();
    }


}

?>