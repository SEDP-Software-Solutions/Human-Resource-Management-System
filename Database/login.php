<?php
include 'database.php';  // Ensure this path is correct

$pdo = $database->connect();  // Use the $database variable to get the PDO instance
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];  // Changed from username to email
    $password = $_POST["password"];

    // To store userType
    $userType = '';

    // Debugging: check received POST data
    var_dump($email, $password);

    // Function to perform case-sensitive search
    function findUserType($pdo, $email, $password, $table)
    {
        // Updated query to use :email instead of :username
        $stmt = $pdo->prepare("SELECT usertype FROM $table WHERE email = BINARY :email AND password = BINARY :password");
        // Bind parameters correctly
        $stmt->execute(['email' => $email, 'password' => $password]);
        return $stmt->fetchColumn();
    }

    // Check in scholar_login
    $userType = findUserType($pdo, $email, $password, 'recipient');
    if (!$userType) {
        // Check in employee_login
        $userType = findUserType($pdo, $email, $password, 'employees');
        if (!$userType) {
            // Check in admin_login
            $userType = findUserType($pdo, $email, $password, 'admin_login');
        }
    }

    // Debugging: check the determined userTypes
    var_dump($userType);

    if ($userType) {
        $_SESSION["email"] = $email;  // Changed from username to email

        switch ($userType) {
            case "scholar":
                $_SESSION['login_success'] = "Welcome $email!";
                $_SESSION['redirect_to'] = "./Scholar Page/App/View/scholar_home.php";
                break;

            case "employee":
                $_SESSION['login_success'] = "Welcome $email!";
                $_SESSION['redirect_to'] = "./Employee Page/App/View/employee_home.php";
                break;

            case "admin":
                $_SESSION['login_success'] = "Welcome $email!";
                $_SESSION['redirect_to'] = "./Admin Page/App/View/AdminDashboard.php";
                break;
        }
        header("Location: ./index.php");
    } else {
        $_SESSION['login_error'] = "Email or password incorrect";  // Updated error message
        header("Location: ./index.php");
    }
    exit();  // Don't forget this line
}
