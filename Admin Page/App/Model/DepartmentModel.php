<?php

class DepartmentModel
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

    public function getAllDepartmentsWithBranchLocations()
    {
        $query = "
            SELECT 
                d.departmentId,
                d.name AS DepartmentName,
                b.location AS BranchLocation
            FROM 
                tblDepartment d
            JOIN 
                tblBranch b ON d.branchId = b.branchId;
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch all results as associative arrays
    }
}
