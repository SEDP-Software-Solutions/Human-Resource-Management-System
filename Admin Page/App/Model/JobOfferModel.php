<?php

class JobOfferModel
{
    private $pdo;

    public function __construct()
    {
        // Include the database class file
        include_once(__DIR__ . '/../../../Database/database.php');

        // include("../../../../Database/database.php"); // Adjust the path as necessary

        // Create a new instance of the Database class
        $database = new Database();

        // Get the PDO connection
        $this->pdo = $database->connect(); // Use the connect method to establish a connection
    }

    // Method to retrieve the job offer name by jobOfferId
    public function getJobIdById($jobOfferId)
    {
        $sql = "SELECT JobId FROM tbljoboffer WHERE JobOfferId = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$jobOfferId]);

        // Fetch the job offer
        $jobId = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the JobId if found, else return an empty string
        return $jobId ? $jobId['JobId'] : '';
    }
    public function getJobOffers($limit = 6)
    {
        $sql = "
            SELECT 
                j.jobId,               
                j.title,
                j.description AS JobDescription,
                j.qualification,
                j.minimumSalary AS min_salary,
                j.maximumSalary AS max_salary,
                jo.jobOfferId,
                jo.employmentType AS EmployeeType,
                jo.datePosted,
                b.location
            FROM 
                tblJobOffer jo
            JOIN 
                tblJob j ON jo.jobId = j.jobId
            JOIN 
                tblDepartment d ON jo.departmentId = d.departmentId
            JOIN 
                tblBranch b ON d.branchId = b.branchId
            LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT); // Bind the limit parameter
        $stmt->execute();

        // Fetch all the job offers as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Method to retrieve job offers with filtering and search criteria
    public function getJobOffersWithFilters($filter, $search)
    {
        $sql = "
        SELECT 
            j.jobId,   
            j.title,
            j.description AS JobDescription,
            j.qualification,
            j.minimumSalary AS min_salary,
            j.maximumSalary AS max_salary,
            jo.jobOfferId,
            jo.employmentType AS EmployeeType,
            jo.datePosted,
            d.departmentId,
            d.name AS DepartmentName,
            b.location
        FROM 
            tblJobOffer jo
        JOIN 
            tblJob j ON jo.jobId = j.jobId
        JOIN 
            tblDepartment d ON jo.departmentId = d.departmentId
        JOIN 
            tblBranch b ON d.branchId = b.branchId
        WHERE 1=1
        ";

        // Apply search logic
        if (!empty($search)) {
            $sql .= " AND j.title LIKE :search";
        }

        // Apply filter logic
        if ($filter === 'newest') {
            $sql .= " ORDER BY jo.datePosted DESC";
        } elseif ($filter === 'oldest') {
            $sql .= " ORDER BY jo.datePosted ASC";
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

    // Method to update job offer
    public function updateJobOffer($jobOfferId, $employmentType, $jobId, $departmentId,)
    {
        // Sanitize input data
        $jobOfferId = htmlspecialchars(trim($jobOfferId));
        $jobId = htmlspecialchars(trim($jobId));
        $departmentId = htmlspecialchars(trim($departmentId));
        $employmentType = htmlspecialchars(trim($employmentType));

        // Prepare the SQL statement
        $stmt = $this->pdo->prepare("UPDATE tblJobOffer SET jobId = ?, departmentId = ?, EmploymentType = ? WHERE jobOfferId = ?");

        // Attempt to execute the statement with the provided parameters
        if ($stmt->execute([$jobId, $departmentId, $employmentType, $jobOfferId])) {
            // Log success
            error_log("Job offer updated successfully: ID $jobOfferId");
            return true; // Return true for successful execution
        } else {
            // Log the error for debugging
            error_log("SQL Error during update: " . print_r($stmt->errorInfo(), true));

            // Return false for unsuccessful execution
            return false;
        }
    }

    // Method to create a new job offer
    public function createJobOffer($employmentType, $jobId, $departmentId)
    {
        // SQL query with placeholders for parameters
        $stmt = $this->pdo->prepare("INSERT INTO tblJobOffer (employmentType, datePosted, jobId, departmentId) VALUES (?, NOW(), ?, ?)");

        // Execute the query with the provided parameters
        if ($stmt->execute([$employmentType, $jobId, $departmentId])) {
            return true;
        } else {
            // Log error information in case of failure
            error_log("SQL Error during insert: " . print_r($stmt->errorInfo(), true));
            return false;
        }
    }

    public function deleteJobOffer($jobOfferId)
    {
        $stmt = $this->pdo->prepare("DELETE FROM tblJobOffer WHERE jobOfferId = ?");
        return $stmt->execute([$jobOfferId]);
    }
}
