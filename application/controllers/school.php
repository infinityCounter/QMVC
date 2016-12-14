<?php

/**
* SchoolCtrl extends the Controller
* which is abstract and cannot be instantiated itself.
**/
class SchoolCtrl extends Controller
{
    /**
    * @var arr $schools stores returnes associative array from table
    **/ 
    public $schools;

    
    /**
    * getSchool()
    * @param  int $schoolId, the primary key of the schools table
    * @return arr returns an array with the contents of the fields for the target school
    **/
    function getSchool($schoolId)
    {
        $this->schools = $this->model->getSchool($schoolId);
        return $this->schools;
    }
    
    /**
    * @method getSchools ()
    * 
    * @return array $schools
    **/
    public function getSchools()
    {
        $this->schools = $this->model->getAllSchools();
        return $this->schools;
    }

    public function deleteSchool($schoolId)
    {
        $this->deleteResult = $this->model->deleteSchool($schoolId);
        return $this->deleteResult;
    }

    public function insertSchool($name, $address, $telephone)
    {
        $this->insertResult = $this->model->insertSchool($name, $address, $telephone);
        return $this->insertResult;
    }

    public function updateSchool($schoolId, $name, $address, $telephone)
    {
        $this->updateResult = $this->model->updateSchool($schoolId, $name, $address, $telephone);
        return $this->updateResult;
    }

    public function render()
    {    
        if ($this->schools === null){
            $this->getSchools();
        }
        require_once(ROOT_PATH . $this->template);
    }
}

?>