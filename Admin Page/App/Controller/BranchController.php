<?php
include_once(__DIR__ . '/../Model/BranchModel.php');

class BranchController
{
    private $branchModel;

    public function __construct()
    {
        $this->branchModel = new BranchModel();
    }
    public function getAllBranch()
    {
        // Call the method from the model to get data
        return $this->branchModel->getAllBranch();
    }


}
