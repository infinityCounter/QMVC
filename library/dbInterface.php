<?php

namespace QMVC;
/**
* dbInterface contains all methods to be defined
* by the database classes that will individually
* handle different types of databases: MySQL, MongoDB
* 
**/  
public interface DBInterface {

    public function selectSingle(){}
    public function selectMultiple(){}
    public function deleteSingle(){}
    public function deleteMultiple(){}
    public function updateSingle(){};
    public function updateMultiple(){};
    public function createSingle(){};
    public function createMultiple(){};
}

?>