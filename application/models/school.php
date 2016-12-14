<?php

/**
*School class extends Model
*/
class SchoolModel extends Model 
{
	
	
	/**
	* Class does not define controller and instead inherits parent controller
	    * Therefore School default connects to datbase specified in database.ini.php
	    * To change database connection file it would be neccessary to set databaseIniFile
	    **/
	
	//p	rivate databaseIniFile = null;
	
	
	/**
	* @method getSchool($schoolId)
	* Takes no argumets, returns all schools in database
	**/
	 public function getSchool($schoolId)
	 {	
		$query = 'SELECT * FROM schools WHERE Id=:Id;';
		$arg = array(':Id' => $schoolId);
		$school = $this->databaseConnection->execQuery($query, $arg);
		return $school;
	}
	
	
	/**
	* @method getAllSchools()
	* Takes no argumets, returns all schools in database
	**/
	public function getAllSchools()
	{	
		$query = 'SELECT * FROM schools;';
		$schools = $this->databaseConnection->execQuery($query);
		return $schools;
	}
	
	public function getAllTeachers()
	{	
		$query = 'SELECT * FROM teachers;';
		$teachers = $this->databaseConnection->execQuery($query);
		return $teachers;
	}
	
	public function deleteSchool($schoolId = '')
	{	
		if (isset($schoolId) && $schoolId !== NULL){
			
			$query = 'DELETE FROM schools WHERE Id=:id;';
			$args = array(':id' => $schoolId);
			$numOfRowsAffected = $this->databaseConnection->execQuery($query, $args);
			return $numOfRowsAffected;
		}
		else{
			return 0;
		}
	}
	
	public function insertSchool($name, $address, $telephone, $principal = NULL)
	{	
		$query = 'INSERT INTO schools (Id, Name, Address, Telephone) 
                    VALUES (NULL, :name, :address, :telephone);';	
		$args = array(
		                ':name' => $name,
		                ':address' => $address,
		                ':telephone' => $telephone
		        );
		$numOfRowsAffected = $this->databaseConnection->execQuery($query, $args);
		return $numOfRowsAffected;
	}
	
	public function updateSchool($schoolId, $name, $address, $telephone, $principal = NULL)
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