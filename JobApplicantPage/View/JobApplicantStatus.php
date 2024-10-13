<?php
$status = ''; // Initialize empty status

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['uniqueId'])) {
    require_once(__DIR__ . '/../../Admin Page/App/Controller/JobApplicantController.php');
    $controller = new JobApplicantController();
    $status = $controller->ViewApplicantStatus(); // Get the status directly
}
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
                    <li class="breadcrumb-item"><a href="../../JobApplicantPage/">Job Offers</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Application Status</li>
                </ol>
            </nav>
            <div class="bg-white m-2 p-3">
                <form action="" method="GET">
                    <div class="row mb-3">
                        <label for="uniqueId" class="col-sm-3 col-form-label">Insert your applicant ID here</label>
                        <div class="col-sm-5">
                            <input type="text" id="uniqueId" name="uniqueId" class="form-control" required>
                        </div>
                        <div class="col-sm-3">
                            <button type="submit" name="submit" class="btn btn-primary">Show Status</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm">
                            <label class="col-sm-4 col-form-label">Your Application Status is: </label>
                            <span><?php echo htmlspecialchars($status); ?></span> <!-- Display the status -->
                        </div>
                    </div>
                </form>
            </div>
        </div>


    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>