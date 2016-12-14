<?php

/**
* interface DBInterface is an interace to be implemented by database handlers
*
* DBInterface contains all methods to be defined
* by the database classes that will individually
* handle different types of databases: MySQL, Postgres
* 
**/  
interface DBInterface 
{

    public function closeConnection();

    public function execQuery($query, $params = null, $fetchmode = PDO::FETCH_ASSOC);

    public function isConnected();

    function __destruct();
}

?>