<?php

/**
* Class SchoolCtrl 
*
* Extends controller class. Contains methods exposed to '/school' route for example
*/
class SchoolCtrl extends Controller
{
    /*** @var arr $schools stores returnes associative array from table */ 
    public $schools;

    
    /**
    * public function getSchool
    *
    * Makes a method call to model to return the row entry for a specific school
    *
    * @param  int The primary key of the schools table
    * @return arr Array with the contents of the fields for the target school
    */
    function getSchool($schoolId)
    {
        $this->schools = $this->model->getSchool($schoolId);
        return $this->schools;
    }
    
    /**
    * public function getSchools
    *
    * Makes a method call to model to return the row entry for all schools
    *
    * @return arr Array of all schools
    */
    public function getSchools()
    {
        $this->schools = $this->model->getAllSchools();
        return $this->schools;
    }

    /**
    * public function deleteSchool
    *
    * Makes a method call to model to delete  the row entry for a specified school
    *
    * @return int Number of rows affected by DELETE operation
    */
    public function deleteSchool($schoolId)
    {
        $this->deleteResult = $this->model->deleteSchool($schoolId);
        return $this->deleteResult;
    }

    /**
    * public function deleteSchool
    *
    * Makes a method call to model to insert the a new school into database with arguments as field values
    *
    * @return int Number of rows affected by INSERT operation
    */
    public function insertSchool($name, $address, $telephone)
    {
        $this->insertResult = $this->model->insertSchool($name, $address, $telephone);
        return $this->insertResult;
    }

    /**
    * public function updateSchool
    *
    * Makes a method call to model to update a school with arguments passed
    *
    * @return int Number of rows affected by UPDATE operation
    */
    public function updateSchool($schoolId, $name, $address, $telephone)
    {
        $this->updateResult = $this->model->updateSchool($schoolId, $name, $address, $telephone);
        return $this->updateResult;
    }

    
    /**
    * public function render
    *
    * Overloads render method of parent, gets all schools and loads template
    *
    * @return void
    */
    public function render()
    {    
        if ($this->schools === null){
            $this->getSchools();
        }
        require_once(ROOT_PATH . $this->template);
    }
}

?>