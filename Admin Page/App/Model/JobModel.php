<?php

class JobModel
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

    // Method to retrieve the title by jobId
    public function getJobTitleById($jobId)
    {
        $sql = "SELECT title FROM tbljob WHERE JobId = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$jobId]);

        // Fetch the title
        $title = $stmt->fetch(PDO::FETCH_ASSOC);

        // Return the job title if found, else return an empty string
        return $title ? $title['title'] : '';
    }

    public function getAllJobs()
    {
        $sql = "SELECT * FROM tbljob";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
