

<?php
class JobApplicantModel
{
    private $pdo; // Database connection

    public function __construct()
    {
        // Include the database class file
        include_once(__DIR__ . '/../../../Database/database.php');

        // Create a new instance of the Database class
        $database = new Database();

        // Get the PDO connection
        $this->pdo = $database->connect(); // Use the connect method to establish a connection
    }

    public function getAllJobApplicants()
    {
        $sql = "SELECT * FROM tbljobapplicant";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Method to retrieve job applicant with filtering and search criteria
    public function getJobApplicantsWithFilters($filter, $search)
    {
        $sql = "SELECT * FROM tbljobapplicant WHERE 1=1";

        // Apply search logic
        if (!empty($search)) {
            $sql .= " AND name LIKE :search";
        }

        // Apply filter logic
        if ($filter === 'newest') {
            $sql .= " ORDER BY appliedDate DESC";
        } elseif ($filter === 'oldest') {
            $sql .= " ORDER BY appliedDate ASC";
        }

        $stmt = $this->pdo->prepare($sql);

        // Bind search parameter if it exists
        if (!empty($search)) {
            $searchParam = "%$search%";
            $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewApplicantStatus($statusId)
    {

        $sql = "SELECT status FROM tbljobapplicant WHERE uniqueId = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$statusId]);

        // Fetch the status
        $Status = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the Status if found, else return an empty string
        return $Status ? $Status['status'] : 'Please insert valid Id';
    }


    // Function to create an applicant with file upload handling
    public function createApplicant($postData, $fileData)
    {
        // Attributes
        $name = "";
        $email = "";
        $status = "Pending"; // Default status
        $jobOfferId = "";
        $contactNumber = "";

        // Combine names into a single string
        $name = htmlspecialchars(trim($postData['lastName'])) . ', ' .
            htmlspecialchars(trim($postData['firstName'])) . ', ' .
            htmlspecialchars(trim($postData['middleName']));

        $email = htmlspecialchars(trim($postData['email']));

        // Generate a unique identifier for each applicant
        $uniqueIdentifier = uniqid('applicant_', true); // Generate a unique ID
        // Get the contactNumber from the form data
        $contactNumber = htmlspecialchars(trim($postData['contactNumber']));

        // Retrieve the job offer ID 
        $jobOfferId = $postData['jobOfferId'];

        // Initialize file-related variables
        $fileName = null;
        $fileSize = null;
        $fileType = null;

        // Directory to store uploaded files
        $target_dir = "../../../Database/uploads/"; //directory to store files
        $allowedTypes = ['pdf', 'docx', 'doc']; // Allowed file types

        // Check if a file was uploaded
        if (isset($fileData['file']['tmp_name']) && is_uploaded_file($fileData['file']['tmp_name'])) {
            $fileType = strtolower(pathinfo($fileData['file']['name'], PATHINFO_EXTENSION)); // Get file type

            if (in_array($fileType, $allowedTypes) && $fileData['file']['size'] < 2000000) { // 2MB limit
                $fileName = uniqid('file_', true) . '.' . $fileType; // Generate unique filename
                $target_file = $target_dir . $fileName;

                // Move the uploaded file to the target directory
                if (move_uploaded_file($fileData['file']['tmp_name'], $target_file)) {
                    // Store file metadata
                    $fileSize = $fileData['file']['size']; // File size in bytes
                    $fileType = $fileData['file']['type']; // MIME type
                } else {
                    // Handle upload error
                    $errorMessage = "Sorry, there was an error uploading your file.";
                    header("location:../../../JobApplicantPage/View/JobApplication.php?msg=" . urlencode($errorMessage));
                    return; // Exit the method
                }
            } else {
                // Handle invalid file type or size
                $errorMessage = "Invalid file type or size. Please upload a valid document.";
                header("location:../../../JobApplicantPage/View/JobApplication.php?msg=" . urlencode($errorMessage));
                return; // Exit the method
            }
        }

        // Log incoming data for debugging purposes
        error_log("Name: " . $name);
        error_log("Contact Number: " . $contactNumber);
        error_log("Job Offer ID: " . $jobOfferId);

        // Store application data in the database (including file metadata)
        $sql = "INSERT INTO tbljobapplicant (uniqueId, name, email, contactNumber, fileName, fileSize, fileType, status, jobOfferId) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        // Execute the statement
        if ($stmt->execute([$uniqueIdentifier, $name, $email, $contactNumber, $fileName, $fileSize, $fileType, $status, $jobOfferId])) {
            return $uniqueIdentifier; // Return the UniqueIdentifier
            // Success message
            //$successMessage = "Your application has been submitted successfully. Your Application ID is: " . $uniqueIdentifier;
            //header("location:../../../../JobPage/JobApplicantStatus.php?msg=" . urlencode($successMessage));
            //header("location:../../../../JobPage/JobApplicationPage.php");
            exit(); // Ensure script execution stops here
        } else {

            // Log the error or display it in a development environment
            error_log("SQL Error: " . print_r($stmt->errorInfo(), true)); // Log detailed error information
            // Error message
            $errorMessage = "There was an error submitting your application. Please try again.";
            header("location:../../../JobApplicantPage/View/JobApplication.php?msg=" . urlencode($errorMessage));
            echo "else";
            exit(); // Ensure script execution stops here
        }
    }
}
