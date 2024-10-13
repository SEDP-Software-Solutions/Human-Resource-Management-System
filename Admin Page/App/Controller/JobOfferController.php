<?php

include_once(__DIR__ . '/../Model/JobOfferModel.php');

class JobOfferController
{
    private $jobOfferModel;

    public function __construct()
    {
        $this->jobOfferModel = new JobOfferModel();
    }

    // Method to get the job offer name by ID
    public function getJobId($jobOfferId)
    {
        return $this->jobOfferModel->getJobIdById($jobOfferId);
    }

    //to display all job offers in the jobapplicantpage
    public function displayJobOffers()
    {
        global $jobOffers;
        $jobOffers = $this->jobOfferModel->getJobOffers();
        include_once(__DIR__ . '/../../../JobApplicantPage/index.php'); //the view to display job offers
    }

    // Method to retrieve job offers based on search and filter criteria
    public function getFilteredJobOffers($filter = '', $search = '')
    {
        // Call the method from the model to get filtered data
        return $this->jobOfferModel->getJobOffersWithFilters($filter, $search);
    }

    //this is to get all joboffers
    public function getJobOffers()
    {
        // Call the method from the model to get data
        return $this->jobOfferModel->getJobOffers();
    }

    // Method to handle job offer update
    public function updateJobOffer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize input data
            $postData = $this->sanitizeInput($_POST);

            // Log sanitized POST data
            error_log(print_r($postData, true));

            // Get the necessary fields from sanitized input
            $jobOfferId = $postData['jobOfferId'] ?? '';
            $jobId = $postData['jobId'] ?? '';
            $departmentId = $postData['departmentId'] ?? '';
            $employmentType = $postData['EmploymentType'] ?? '';

            // Call the update method
            if ($this->jobOfferModel->updateJobOffer($jobOfferId, $employmentType, $jobId, $departmentId)) {
                // Redirect on success
                header("Location: ../View/ReqcruitmentPage.php?msg=success");
                exit(); // Make sure to exit after a redirect
            } else {
                // Handle the error if the update fails
                header("Location: ../View/ReqcruitmentPage.php?msg=error");
                exit();
            }
        } else {
            return false; // Indicate invalid request method
        }
    }

    // Method to handle creating a new job offer
    public function createJobOffer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate input data
            $postData = $this->sanitizeInput($_POST);

            // Extract necessary fields from sanitized input
            $jobId = $postData['jobId'] ?? '';
            $departmentId = $postData['departmentId'] ?? '';
            $employmentType = $postData['EmploymentType'] ?? '';

            // Call the model method to insert the job offer
            if ($this->jobOfferModel->createJobOffer($employmentType, $jobId, $departmentId)) {
                // Redirect on success
                header("Location: ../View/ReqcruitmentPage.php?msg=success");
                exit();
            } else {
                // Redirect with an error message if insertion fails
                header("Location: ../View/ReqcruitmentPage.php?msg=error");
                exit();
            }
        } else {
            // If not a POST request, simply return false
            return false;
        }
    }

    // Method to delete job offer
    public function deleteJobOffer()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $jobOfferId = $_POST['jobOfferId'] ?? '';

            if ($this->jobOfferModel->deleteJobOffer($jobOfferId)) {
                header("Location: ../View/ReqcruitmentPage.php?msg=deleted");
                exit();
            } else {
                header("Location: ../View/ReqcruitmentPage.php?msg=delete_error");
                exit();
            }
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
}
$controller = new JobOfferController();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'update':
            $controller->updateJobOffer();
            break;
        case 'create':
            $controller->createJobOffer();
            break;
        case 'delete':
            $controller->deleteJobOffer();
            break;
        default:
            // Handle unknown action
            // header("location: ../../../JobApplicantPage/View/JobApplication.php?msg=" . urlencode("Unknown action."));
            break;
    }
} else {
    // Default action (viewing applicant status)
    //$controller->ViewApplicantStatus();
}
