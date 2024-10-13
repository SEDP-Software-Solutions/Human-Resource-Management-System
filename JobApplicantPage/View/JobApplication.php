<?php

require_once(__DIR__ . '/../../Admin Page/App/Controller/JobOfferController.php');
require_once(__DIR__ . '/../../Admin Page/App/Controller/JobController.php');
//instance of JobOfferController
$jobOfferController = new JobOfferController();
$jobController = new JobController();

$jobId = $jobOfferController->getJobId($_GET['job_id']);
$jobTitle = $jobController->getJobTitle($jobId);

// Initialize variables to avoid undefined variable warnings
$name = "";
$file = null;
$status = "Pending"; // Default status
$jobOfferId = "";
$positionApplied = "";
$showModal = false;
$uniqueIdentifier = '';

if (isset($_GET['uniqueIdentifier'])) {
    $uniqueIdentifier = $_GET['uniqueIdentifier'];
}

// Check if modal should be shown
$showModal = isset($_GET['showModal']) ? true : false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Landing Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!--<link rel="stylesheet" href="../../public/assets/css/employee/emInfo.css">-->

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
</head>

<body>
    <style>
        body {
            background-color: #f0f0f0;
            font-family: 'poppins', sans-serif;
        }
    </style>
    <!--Nav-->
    <nav class="navbar navbar-expand-lg navbar-light bg-gradient bg-opacity-75" style="background-color: #003c3c;">
        <div class="container d-flex mb-1">
            <a class="navbar-brand text-white align-text-center fw-bolder fs-5" href="../index.php">
                SEDP Simbag Sa Pag-Asenso Inc.
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navmenu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
    <section>
        <div class="container mb-5 mt-4 bg-light p-3">
            <nav aria-label="breadcrumb" class="my-0.5">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="../../">Home</a></li>
                    <li class="breadcrumb-item"><a href="../../JobApplicantPage/">Job Lists</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Job Application</li>
                </ol>
            </nav>
            <div class="bg-white m-2 p-3">
                <form action="../../Admin Page/App/Controller/JobApplicantController.php?action=apply" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="job_id" name="jobOfferId" value="<?php echo $_GET['job_id']; ?>"> <!-- Hidden field for jobOfferId -->
                    <p>INSTRUCTION: Please provide the necessary information and upload the application form here</p>

                    <!-- Position Applied -->
                    <div class="row mb-3">
                        <label for="positionApplied" class="col-sm-2 col-form-label">Position applied for</label>
                        <div class="col-sm-5">
                            <input type="text" name="positionApplied" value="<?php echo htmlspecialchars($jobTitle); ?>" class="form-control" id="positionApplied" readonly>
                        </div>
                    </div>

                    <!-- Name Input -->
                    <div class="row mb-3">
                        <label for="name" class="col-sm-1 col-form-label">Name</label>
                        <div class="col-sm-4">
                            <input name="lastName" type="text" class="form-control" placeholder="Last Name" required>
                        </div>
                        <div class="col-sm-4">
                            <input name="firstName" type="text" class="form-control" placeholder="First Name" required>
                        </div>
                        <div class="col-sm-3">
                            <input name="middleName" type="text" class="form-control" placeholder="Middle Name">
                        </div>
                    </div>
                    <!-- email Input -->
                    <div class="row mb-3">
                        <label for="email" class="col-sm-1 col-form-label">Email</label>
                        <div class="col-sm-4">
                            <input name="email" type="email" class="form-control" placeholder="Email" required>
                        </div>
                    </div>

                    <!-- Contact Number Inputs -->
                    <div class="row mb-3">
                        <label for="positionApplied" class="col-sm-2 col-form-label">Contact Number</label>
                        <div class="col-sm-5">
                            <input type="text" id="contactnumber" name="contactNumber" class="form-control"
                                placeholder="contact number"
                                pattern="^[0-9]{10,15}$"
                                title="Please enter a positive integer."
                                required oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="row mb-3">
                        <label for="file" class="col-sm-3 col-form-label">Upload Application Form</label>
                        <div class="col-sm-9">
                            <input type="file" id="file" name="file" class="form-control" accept=".pdf,.doc,.docx" required>
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit Application</button>
                </form>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Your application has been submitted successfully!</h1>
                        </div>
                        <div class="modal-body">
                            <strong>PLEASE SAVE YOUR UNIQUE ID!!!</strong> <br>
                            Your Unique Id is: <strong><?php echo htmlspecialchars($uniqueIdentifier); ?></strong>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="saveAsText('<?php echo htmlspecialchars($uniqueIdentifier); ?>')">Save Text</button>
                            <button type="button" class="btn btn-primary" onclick="window.location.href='JobApplicantStatus.php'"> Okay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
        // Function to save the UniqueIdentifier as a .txt file
        function saveAsText(uniqueIdentifier) {
            const blob = new Blob([uniqueIdentifier], {
                type: 'text/plain'
            });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'UniqueIdentifier.txt';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        // Show the modal if there's a unique identifier
        <?php if ($showModal): ?>
            var modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
            modal.show();
        <?php endif; ?>
    </script>
</body>

</html>