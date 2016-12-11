<?php
//BROKEN IN CURRENT COMMIT
class Model {

    private $databaseConnection;

    function __construct($databaseType = 'mysql', $dbInifile){

        if($databaseType === 'mysql'){

            parse_ini_file("database.ini.php");

            ($host, $port, $dbname, $username, $password)
            $this->databaseConnection = new SqlDatabase();
        }
    }
}
?>