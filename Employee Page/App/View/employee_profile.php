<?php 
session_start();

if (!isset($_SESSION["username"])) {
    header("location:../../index.php");
    exit();
}

$title = 'Employee Dashboard | SEDP HRMS';
$page = 'employeeDashboard';
include('../../Core/Includes/header.php');
?>
    <h1 style="font-size: 20rem;">Hello Employee</h1>
</body>
</html>