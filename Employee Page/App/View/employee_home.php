<?php
session_start();


if (!isset($_SESSION["username"])) {
    header("location:../../index.php");
}
?>

<?php
$title = 'Home';
$page = 'home';
include('../../Core/Includes/header.php');
?>

<?php include('../../Core/Includes/footer.php'); ?>