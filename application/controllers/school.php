<?php

/**
* SchoolCtrl extends the Controller
* which is abstract and cannot be instantiated itself.
**/
class SchoolCtrl extends Controller
{

    public $schools;

    /**
    * Does not defined controller, instead inherits parant controller
    **/

    function getSchool($schoolId = NULL)
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

    public function deleteSchool($schoolId = NULL)
    {
        $this->deleteResult = $this->model->deleteSchool($schoolId);
        return $this->deleteResult;
    }

    public function insertSchool($name = NULL, $address, $telephone, $principal = NULL)
    {
        $this->insertResult = $this->model->insertSchool($name, $address, $telephone, $principal);
        return $this->insertResult;
    }

    public function updateSchool($schoolId = NULL, $name = NULL, $address, $telephone, $principal = NULL)
    {
        $this->updateResult = $this->model->updateSchool($schoolId, $name, $address, $telephone, $principal);
        return $this->updateResult;
    }

    public function render()
    {    
        if($this->schools === NULL){
            $this->getSchools();
        }
        require_once(ROOT_PATH . $this->template);
    }
}

?>