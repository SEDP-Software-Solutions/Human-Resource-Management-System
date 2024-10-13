<?php

include_once(__DIR__ . '/../Model/JobModel.php');

class JobController
{
    private $jobModel;

    public function __construct()
    {
        $this->jobModel = new JobModel();
    }
    // Method to get the Job title by ID
    public function getJobTitle($jobId)
    {
        return $this->jobModel->getJobTitleById($jobId);
    }

    public function getAllJobs()
    {
        // Call the method from the model to get data
        return $this->jobModel->getAllJobs();
    }
}
