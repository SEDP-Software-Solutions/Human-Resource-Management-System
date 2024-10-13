<?php
// Database connection
include("../../../../Database/database.php");

// Get the application ID from the form
$applicationId = $_POST['applicationId'];

// Query the database to get the status of the application
$sql = "SELECT status FROM JobApplications WHERE uniqueIdentifier = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $applicationId);
$stmt->execute();
$stmt->bind_result($status);
$stmt->fetch();

// Display the status
if ($status) {
    echo "Your application status is: " . $status;
} else {
    echo "Invalid Application ID. Please check your ID and try again.";
}

// Close connection
$stmt->close();
$conn->close();
