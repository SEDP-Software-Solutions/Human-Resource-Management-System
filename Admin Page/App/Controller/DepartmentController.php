<?php
include_once(__DIR__ . '/../Model/DepartmentModel.php');

class DepartmentController

{
    private $departmentModel;

    public function __construct()
    {
        $this->departmentModel = new DepartmentModel();
    }

    // Method to handle the request for all department names with branch locations
    public function getAllDepartmentsWithBranchLocations()
    {
        // Call the model method to retrieve data
        return $this->departmentModel->getAllDepartmentsWithBranchLocations();
    }
}
