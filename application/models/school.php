<?php

/**
* Class SchoolModel
*
* Class extends the Model class. Contains operations that will manipulate database and communicate with controller.
* 
*/
class SchoolModel extends Model 
{	
	/**
	* Class does not define controller and instead inherits parent controller
	* Therefore School default connects to datbase specified in database.ini.php
	* To change database connection file it would be neccessary to set databaseIniFile
	*/
	
	/**
	* public function getSchool
	*
	* Performs SELECT operation on database to return a specific entry from schools table
	* 
	* @param int The id of the school to be returned
	* @return arr The array of rows return from query
	*/
	 public function getSchool($schoolId)
	 {	
		//SQL Query to be executed
		$query = 'SELECT * FROM schools WHERE Id=:Id;';
		//Query arguments
		$arg = array(':Id' => $schoolId);
		//Execute query and store value in $school
		$school = $this->databaseConnection->execQuery($query, $arg);
		return $school;
	}
	
	
	/**
	* public function getAllSchools
	*
	* Performs SELECT operation on database to return all entries from schools table
	* 
	* @param arr The array of rows returned from query
	*/
	public function getAllSchools()
	{	
		$query = 'SELECT * FROM schools;';
		$schools = $this->databaseConnection->execQuery($query);
		return $schools;
	}
	
	/**
	* public function deleteSchool
	*
	* Performs DELETE operation on database to remove a specific entry from schools table
	* 
	* @param int The id of the school to be deleted
	* @return int number of rows modified by query
	*/
	public function deleteSchool($schoolId = '')
	{	
		$query = 'DELETE FROM schools WHERE Id=:id;';
		$args = array(':id' => $schoolId);
		$numOfRowsAffected = $this->databaseConnection->execQuery($query, $args);
		return $numOfRowsAffected;
	}
	
	/**
	* public function insertSchool
	*
	* Performs INSERT operation on database to add an entry to schools table
	* 
	* @param string The name of school to be added
	* @param string The telephone of school to be added
	* @param string The address of school to be added
	* @return int number of rows affected by query
	*/
	public function insertSchool($name, $address, $telephone)
	{	
		//INSERT query, leaves Id blank since table is auto incrementing and will assign primary key itself
		$query = 'INSERT INTO schools (Id, Name, Address, Telephone) 
                    VALUES (null, :name, :address, :telephone);';	
		//Array of arguments for query
		$args = array(
		                ':name' => $name,
		                ':address' => $address,
		                ':telephone' => $telephone
		        );
		$numOfRowsAffected = $this->databaseConnection->execQuery($query, $args);
		return $numOfRowsAffected;
	}
	
	/**
	* public function updateSchool
	*
	* Performs INSERT operation on database to add an entry to schools table
	* 
	* @param string | int The id of school to be updated
	* @param string The name of school to be updated
	* @param string The telephone of school to be updated
	* @param string The address of school to be updated
	* @return int number of rows affected by query
	*/
	public function updateSchool($schoolId, $name, $address, $telephone)
	{	
		$query = "UPDATE schools SET Name=:name, Address=:address, Telephone=:telephone WHERE Id=:Id;";	
		$args = array(
		                ':name' => $name,
		                ':address' => $address,
		                ':telephone' => $telephone,
		                ':Id' => $schoolId
		        );
		$numOfRowsAffected = $this->databaseConnection->execQuery($query, $args);
		return $numOfRowsAffected;
	}
}
?>