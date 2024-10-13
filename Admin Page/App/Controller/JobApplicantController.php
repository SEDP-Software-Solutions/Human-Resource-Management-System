<?php
include_once(__DIR__ . '/../Model/JobApplicantModel.php');
include_once(__DIR__ . '/../Model/JobOfferModel.php');

class JobApplicantController
{
    private $jobApplicantmodel;

    public function __construct()
    {
        $this->jobApplicantmodel = new JobApplicantModel();
    }

    // Method to display all job applicants
    public function ViewAllApplicants()
    {
        $applicants = $this->jobApplicantmodel->getAllJobApplicants();
        // Include the view to display the applicants
        include(__DIR__ . '/../../../JobPage/JobOffer/View/AllJobOffers.php');
    }

    // Method to display job applicants status
    public function ViewApplicantStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $statusId = $this->sanitizeInput($_GET['uniqueId']);
            $status = $this->jobApplicantmodel->viewApplicantStatus($statusId);

            // return the status for direct display
            return $status;
        }
    }
    // Method to handle the application submission
    public function submitApplication()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input data
            $postData = $this->sanitizeInput($_POST);

            error_log(print_r($postData, true)); // Log sanitized POST data
            error_log(print_r($_FILES, true)); // Log uploaded file data     

            // Check if a file has been uploaded
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                // Call the createApplicant method from the JobApplicant model with both postData and fileData
                $fileData = $_FILES; // Pass the uploaded file data

                // Call createApplicant to insert and get uniqueIdentifier
                $uniqueId = $this->jobApplicantmodel->createApplicant($postData, $fileData);

                if ($uniqueId) {
                    // Get job_id from POST data
                    $jobId = isset($postData['jobOfferId']) ? $postData['job_id'] : '';

                    // Redirect to the form page with job_id
                    header("Location:../../../JobApplicantPage/View/JobApplication.php?job_id=" . urlencode($jobId) . "&uniqueIdentifier=" . urlencode($uniqueId) . "&showModal=true");
                    exit();
                } else {
                    // Handle error
                }
            } else {
                // Handle file upload error
                $errorMessage = "File upload failed. Please try again.";
                return false; // Indicate failure
            }
        } else {
            return false; // Indicate invalid request method
        }
    }

    // Method to sanitize input data
    private function sanitizeInput($data)
    {
        if (is_array($data)) {
            return array_map(function ($value) {
                return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
            }, $data);
        } else {
            // Handle single value (string)
            return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
        }
    }

    // Method to retrieve job applicants based on search and filter criteria
    public function getFilteredJobApplicants($filter = '', $search = '')
    {
        // Call the method from the model to get filtered data
        return $this->jobApplicantmodel->getJobApplicantsWithFilters($filter, $search);
    }
}

// Instantiate the controller
$controller = new JobApplicantController();

// Handle the action based on the request
if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'viewAll':
            $controller->ViewAllApplicants();
            break;
        case 'apply':
            $controller->submitApplication();
            break;
        case 'viewStatus':
            $controller->ViewApplicantStatus();
            break;
        default:
            // Handle unknown action
            header("location: ../../../JobApplicantPage/View/JobApplication.php?msg=" . urlencode("Unknown action."));
            break;
    }
} else {
    // Default action (viewing applicant status)
    //$controller->ViewApplicantStatus();
}
