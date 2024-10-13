<?php
// Database connection
include("../../../../Database/database.php");

// Attributes
$name = "";
$appliedDate = "";
$applicationData = "";
$status = "Pending"; // Default status
$jobOfferId = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Combine names into a single string
    $name = htmlspecialchars(trim($_POST['lastName'])) . ', ' . htmlspecialchars(trim($_POST['firstName'])) . ', ' . htmlspecialchars(trim($_POST['middleName']));


    // Generate a unique identifier for each applicant
    $uniqueIdentifier = uniqid('applicant_', true); // This creates a unique ID like applicant_605c5ecf4fa13

    // Store the applied date and other form data
    $appliedDate = $_POST['appliedDate'];

    // Encode the application data into JSON format
    $applicationData = json_encode([
        "BasicInfo" => [
            "PermanentAddress" => [
                "Street" => htmlspecialchars(trim($_POST['street']), ENT_QUOTES, 'UTF-8'),
                "Barangay" => htmlspecialchars(trim($_POST['barangay']), ENT_QUOTES, 'UTF-8'),
                "City/Municipality" => htmlspecialchars(trim($_POST['cityOrMunicipality']), ENT_QUOTES, 'UTF-8'),
                "ZipCode" => htmlspecialchars(trim($_POST['zipCode']), ENT_QUOTES, 'UTF-8')
            ],
            "PresentAddress" => [
                "Street" => htmlspecialchars(trim($_POST['street1']), ENT_QUOTES, 'UTF-8'),
                "Barangay" => htmlspecialchars(trim($_POST['barangay1']), ENT_QUOTES, 'UTF-8'),
                "City/Municipality" => htmlspecialchars(trim($_POST['cityOrMunicipality1']), ENT_QUOTES, 'UTF-8'),
                "ZipCode" => htmlspecialchars(trim($_POST['zipCode1']), ENT_QUOTES, 'UTF-8')
            ],
            "DateOfBirth" => htmlspecialchars(trim($_POST['dateOfBirth']), ENT_QUOTES, 'UTF-8'),
            "Age" => htmlspecialchars(trim($_POST['age']), ENT_QUOTES, 'UTF-8'),
            "Gender" => htmlspecialchars(trim($_POST['gender']), ENT_QUOTES, 'UTF-8'),
            "Religion" => htmlspecialchars(trim($_POST['religion']), ENT_QUOTES, 'UTF-8'),
            "CivilStatus" => [
                "status" => htmlspecialchars(trim($_POST['civilStatus']), ENT_QUOTES, 'UTF-8'), // Single or married
                "details" => htmlspecialchars(trim($_POST['civilStatus']), ENT_QUOTES, 'UTF-8') === 'married' ? [
                    "Civil" => htmlspecialchars(trim($_POST['civil']), ENT_QUOTES, 'UTF-8'),
                    "Church" => htmlspecialchars(trim($_POST['church']), ENT_QUOTES, 'UTF-8')
                ] : null
            ],
            "SingleParent" => htmlspecialchars(trim($_POST['singleParent']), ENT_QUOTES, 'UTF-8'),
            "LiveIn" => htmlspecialchars(trim($_POST['liveIn']), ENT_QUOTES, 'UTF-8'),
            "IsReceivedBaptism" => htmlspecialchars(trim($_POST['isReceivedBaptism']), ENT_QUOTES, 'UTF-8'),
            "EmailAddress" => htmlspecialchars(trim($_POST['emailAddress']), ENT_QUOTES, 'UTF-8'),
            "LearnAboutPosition" => htmlspecialchars(trim($_POST['learnAboutPosition']), ENT_QUOTES, 'UTF-8'),
            "ReferredBy" => htmlspecialchars(trim($_POST['referredBy']), ENT_QUOTES, 'UTF-8'),
            "Agency" => htmlspecialchars(trim($_POST['agency']), ENT_QUOTES, 'UTF-8'),
            "RadioAdStation" => htmlspecialchars(trim($_POST['radioAdStation']), ENT_QUOTES, 'UTF-8'),
            "DidAppliedPreviously" => htmlspecialchars(trim($_POST['didAppliedPreviously']), ENT_QUOTES, 'UTF-8'),
            "DateApplied" => $_POST['didAppliedPreviously'] === 'Yes' ? $_POST['dateApplied'] : null,
            "FamilyMembersWorkAtSEDP" => !empty($_POST['sedpMemberName1']) || !empty($_POST['sedpMemberName2']) ? [
                [
                    "SEDPMemberName" => htmlspecialchars(trim($_POST['sedpMemberName1']), ENT_QUOTES, 'UTF-8'),
                    "SEDPRelationship" => htmlspecialchars(trim($_POST['sedpRelationship1']), ENT_QUOTES, 'UTF-8')
                ],
                [
                    "SEDPMemberName" => htmlspecialchars(trim($_POST['sedpMemberName2']), ENT_QUOTES, 'UTF-8'),
                    "SEDPRelationship" => htmlspecialchars(trim($_POST['sedpRelationship2']), ENT_QUOTES, 'UTF-8')
                ]
            ] : null,  // If no family members are provided, set to null
            "FamilyMembersWorkAtMFI" => !empty($_POST['mfiMemberName1']) || !empty($_POST['mfiMemberName2']) ? [
                [
                    "MFIMemberName" => htmlspecialchars(trim($_POST['mfiMemberName1']), ENT_QUOTES, 'UTF-8'),
                    "MFIRelationship" => htmlspecialchars(trim($_POST['mfiRelationship1']), ENT_QUOTES, 'UTF-8')
                ],
                [
                    "MFIMemberName" => htmlspecialchars(trim($_POST['mfiMemberName2']), ENT_QUOTES, 'UTF-8'),
                    "MFIRelationship" => htmlspecialchars(trim($_POST['mfiRelationship2']), ENT_QUOTES, 'UTF-8')
                ]
            ] : null,  // If no family members are provided, set to null
            "IsValidDriversLicense" => $_POST['isValidDriverslicense'] === 'Yes' ? $_POST['licenseType'] : null,
            "DesiredSalary" => htmlspecialchars(trim($_POST['desiredSalary']), ENT_QUOTES, 'UTF-8')
        ],
        "Education" => [
            "PostGraduate" => htmlspecialchars(trim($_POST['postGraduate']), ENT_QUOTES, 'UTF-8'),
            "GraduatedPostGraduate" => htmlspecialchars(trim($_POST['graduatedPostGraduate']), ENT_QUOTES, 'UTF-8'),
            "BachelorsDegree" => htmlspecialchars(trim($_POST['bachelorsDegree']), ENT_QUOTES, 'UTF-8'),
            "GraduatedBachelorsDegree" => htmlspecialchars(trim($_POST['graduatedBachelorsDegree']), ENT_QUOTES, 'UTF-8'),
            "vocationOrNonFormal" => htmlspecialchars(trim($_POST['VocationOrNonFormal']), ENT_QUOTES, 'UTF-8'),
            "GraduatedVocationOrNonFormal" => htmlspecialchars(trim($_POST['graduatedVocationOrNonFormal']), ENT_QUOTES, 'UTF-8')
        ],
        "EmploymentHistory" => [
            [
                "RecentEmployer" => htmlspecialchars(trim($_POST['recentEmployer']), ENT_QUOTES, 'UTF-8'),
                "PositionHeld" => htmlspecialchars(trim($_POST['positionHeld']), ENT_QUOTES, 'UTF-8'),
                "Address" => htmlspecialchars(trim($_POST['address']), ENT_QUOTES, 'UTF-8'),
                "SupervisorsNameOrPositionTitle" => htmlspecialchars(trim($_POST['supervisorsNameOrPositionTitle']), ENT_QUOTES, 'UTF-8'),
                "ContactNumber" => htmlspecialchars(trim($_POST['contactNumber']), ENT_QUOTES, 'UTF-8'),
                "DateEmployedStart" => htmlspecialchars(trim($_POST['dateEmployedStart']), ENT_QUOTES, 'UTF-8'),
                "DateEmployedEnd" => htmlspecialchars(trim($_POST['dateEmployedEnd']), ENT_QUOTES, 'UTF-8'),
                "Salary" => htmlspecialchars(trim($_POST['salary']), ENT_QUOTES, 'UTF-8'),
                "JobSummary" => htmlspecialchars(trim($_POST['jobSummary']), ENT_QUOTES, 'UTF-8'),
                "ReasonForLiving" => htmlspecialchars(trim($_POST['reasonForLiving']), ENT_QUOTES, 'UTF-8')
            ],
            [
                "RecentEmployer" => htmlspecialchars(trim($_POST['recentEmployer']), ENT_QUOTES, 'UTF-8'),
                "PositionHeld" => htmlspecialchars(trim($_POST['positionHeld']), ENT_QUOTES, 'UTF-8'),
                "Address" => htmlspecialchars(trim($_POST['address']), ENT_QUOTES, 'UTF-8'),
                "SupervisorsNameOrPositionTitle" => htmlspecialchars(trim($_POST['supervisorsNameOrPositionTitle']), ENT_QUOTES, 'UTF-8'),
                "ContactNumber" => htmlspecialchars(trim($_POST['contactNumber']), ENT_QUOTES, 'UTF-8'),
                "DateEmployedStart" => htmlspecialchars(trim($_POST['dateEmployedStart']), ENT_QUOTES, 'UTF-8'),
                "DateEmployedEnd" => htmlspecialchars(trim($_POST['dateEmployedEnd']), ENT_QUOTES, 'UTF-8'),
                "Salary" => htmlspecialchars(trim($_POST['salary']), ENT_QUOTES, 'UTF-8'),
                "JobSummary" => htmlspecialchars(trim($_POST['jobSummary']), ENT_QUOTES, 'UTF-8'),
                "ReasonForLiving" => htmlspecialchars(trim($_POST['reasonForLiving']), ENT_QUOTES, 'UTF-8')
            ],
            [
                "RecentEmployer" => htmlspecialchars(trim($_POST['recentEmployer']), ENT_QUOTES, 'UTF-8'),
                "PositionHeld" => htmlspecialchars(trim($_POST['positionHeld']), ENT_QUOTES, 'UTF-8'),
                "Address" => htmlspecialchars(trim($_POST['address']), ENT_QUOTES, 'UTF-8'),
                "SupervisorsNameOrPositionTitle" => htmlspecialchars(trim($_POST['supervisorsNameOrPositionTitle']), ENT_QUOTES, 'UTF-8'),
                "ContactNumber" => htmlspecialchars(trim($_POST['contactNumber']), ENT_QUOTES, 'UTF-8'),
                "DateEmployedStart" => htmlspecialchars(trim($_POST['dateEmployedStart']), ENT_QUOTES, 'UTF-8'),
                "DateEmployedEnd" => htmlspecialchars(trim($_POST['dateEmployedEnd']), ENT_QUOTES, 'UTF-8'),
                "Salary" => htmlspecialchars(trim($_POST['salary']), ENT_QUOTES, 'UTF-8'),
                "JobSummary" => htmlspecialchars(trim($_POST['jobSummary']), ENT_QUOTES, 'UTF-8'),
                "ReasonForLiving" => htmlspecialchars(trim($_POST['reasonForLiving']), ENT_QUOTES, 'UTF-8')
            ]
        ],
        "MedicalHistory" => [
            "StateOfHealth" => htmlspecialchars(trim($_POST['stateOfHealth']), ENT_QUOTES, 'UTF-8'),
            "illnesses" => [
                [
                    "name" => "Allergy",
                    "hasIllness" => !empty($_POST['allergy']) ? true : false
                ],
                [
                    "name" => "ThyroidDisease",
                    "hasIllness" => !empty($_POST['thyroidDisease']) ? true : false
                ],
                [
                    "name" => "ChestOrHeartProblem",
                    "hasIllness" => !empty($_POST['chestOrHeartProblem']) ? true : false
                ],
                [
                    "name" => "FrequentHeadache",
                    "hasIllness" => !empty($_POST['frequentHeadache']) ? true : false
                ],
                [
                    "name" => "EyeTrouble",
                    "hasIllness" => !empty($_POST['eyeTrouble']) ? true : false
                ],
                [
                    "name" => "HeadOrNeckInjury",
                    "hasIllness" => !empty($_POST['headOrNeckInjury']) ? true : false
                ],
                [
                    "name" => "AbdominalTrouble",
                    "hasIllness" => !empty($_POST['abdominalTrouble']) ? true : false
                ],
                [
                    "name" => "AnyRepartriation",
                    "hasIllness" => !empty($_POST['anyRepartriation']) ? true : false
                ],
                [
                    "name" => "Arthritis",
                    "hasIllness" => !empty($_POST['arthritis']) ? true : false
                ],
                [
                    "name" => "DiabetesMellitus",
                    "hasIllness" => !empty($_POST['diabetesMellitus']) ? true : false
                ],
                [
                    "name" => "BloodDisorder",
                    "hasIllness" => !empty($_POST['bloodDisorder']) ? true : false
                ],
                [
                    "name" => "GeneticDisorder",
                    "hasIllness" => !empty($_POST['geneticDisorder']) ? true : false
                ],
                [
                    "name" => "TyphoidFever",
                    "hasIllness" => !empty($_POST['typhoidFever']) ? true : false
                ],
                [
                    "name" => "FaintingOrSeizure",
                    "hasIllness" => !empty($_POST['faintingOrSeizure']) ? true : false
                ],
                [
                    "name" => "UrinaryTrouble",
                    "hasIllness" => !empty($_POST['urinaryTrouble']) ? true : false
                ],
                [
                    "name" => "Asthma",
                    "hasIllness" => !empty($_POST['asthma']) ? true : false
                ],
                [
                    "name" => "PulmonaryTuberculosis",
                    "hasIllness" => !empty($_POST['pulmonaryTuberculosis']) ? true : false
                ],
                [
                    "name" => "Other",
                    "hasIllness" => !empty($_POST['otherIllness']) ? true : false,
                    "details" => $_POST['otherIllness']
                ]
            ],
            "UndergoneSurgery" => htmlspecialchars(trim($_POST['undergoneSurgery']), ENT_QUOTES, 'UTF-8'),
            "TakingMaintenanceMed" => htmlspecialchars(trim($_POST['takingMaintenanceMed']), ENT_QUOTES, 'UTF-8'),
            "IsSmokeCig" => htmlspecialchars(trim($_POST['isSmokeCig']), ENT_QUOTES, 'UTF-8'),
            "IsDrinkAlcohol" => $_POST['isDrinkAlcohol'] === 'Yes' ? $_POST['howOften'] : null
        ],
    ]);

    // Set status
    $status = $_POST['status'];

    // Retrieve the job offer ID if available (assuming it is posted in the form)
    $jobOfferId = $_POST['jobOfferId'];

    // Store application data in the database, including the unique identifier
    $sql = "INSERT INTO JobApplications (UniqueIdentifier, Name, AppliedDate, ApplicationData, JobOfferId, Status) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    // Bind the parameters
    $stmt->bind_param(
        "ssssss",
        $uniqueIdentifier,   // Unique identifier
        $name,               // Name
        $appliedDate,        // Date of application
        $applicationData,    // JSON-encoded application data
        $jobOfferId,         // Job Offer ID
        $status              // Application status (Pending by default)
    );

    // Execute the statement
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        //echo json_encode(["status" => "success", "uniqueIdentifier" => $uniqueIdentifier]);
        //echo "Your application has been submitted successfully. Your Application ID is: " . $uniqueIdentifier;

        //TODO: send a message to applicant(message,identifier)

        $successMessage = "Your application has been submitted successfully. Your Application ID is: " . $uniqueIdentifier;
        header("location:../../View/JobApplicants.php?msg=" . urlencode($successMessage));
    } else {
        //echo json_encode(["status" => "error"]);
        $errorMessage = "There was an error submitting your application. Please try again." . $connection->error;
        header("location:../../View/JobApplicants.php?msg=" . urlencode($errorMessage));
    }
}
