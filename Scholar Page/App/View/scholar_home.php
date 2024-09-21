<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location:../../index.php");
    exit();
}

$title = 'Home | SEDP HRMS';
$page = 'home';
include('../../Core/Includes/header.php');
?>

<div class="container-fluid" style="background-color: #f8f9fa; padding-top: 75px;">
    <div class="row">
        <div class="col-12 text-center pt-5">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
        </div>
    </div>
</div>

<?php include('../../Core/Includes/footer.php'); ?>
