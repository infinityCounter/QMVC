<?php

/**
*
**/

class Model {
	
	
	protected $databaseIniFile = 'config/database.ini.php';
	protected $databaseConnection;
	
	
	function __construct(){
		
		if(file_exists(ROOT_PATH . $this->databaseIniFile)){		
			$settings = parse_ini_file(ROOT_PATH . $this->databaseIniFile);
			$this->databaseConnection = new SqlDatabase($settings['host'], $settings['port'], 
			$settings['dbname'], $settings['user'], $settings['password']);
		}
		
	}
	
}

?>