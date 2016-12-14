<?php

/**
* abstract class Model 
*
* Abstract class to define models
* CANNOT BE INSTANTIATED, MUST BE EXTENDED
**/

abstract class Model 
{	
	protected $databaseIniFile = 'config/database.ini.php'; //default databse configuration file
	protected $databaseConnection;	//datbase connection
	
	/**
	* Class constructor.
	*
	* parses database ini file, to get settings and makes a new connection using an SqlDatabase by default
	*/
	function __construct()
	{
		//If the database init file defined by the model exists.
		if (file_exists(ROOT_PATH . $this->databaseIniFile)){
					
			$settings = parse_ini_file(ROOT_PATH . $this->databaseIniFile);
			$this->databaseConnection = new MySqlDatabase($settings['host'], $settings['port'], 
			$settings['dbname'], $settings['user'], $settings['password']);
		}
		
	}
	
}

?>