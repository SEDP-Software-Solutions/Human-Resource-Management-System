<?php
    include("../../../Database/database.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Default Title'; ?></title>

    <link rel="shortcut icon" href="../../../Assets/Images/SEDPfavicon.png" type="image/x-icon">
    <link rel="stylesheet" href="../../Public/Assets/Css/header.css">
    <link rel="stylesheet" href="../../Public/Assets/Css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #003c3c;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            height: 70px;
            padding: 0 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            margin: 0;
        }

        nav {
            display: flex;
            align-items: center;
            width: 100%;
        }

        nav ul {
            list-style: none;
            display: flex;
            gap: 0;
            align-items: center;
            margin: 0;
            padding: 3px;
        }

        nav ul li {
            display: inline;
            padding: 0 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            position: relative;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #007bff;
        }

        nav ul li.home a:hover,
        nav ul li.scholar-compliance a:hover {
            color: inherit;
        }

        nav ul li a.sedp-link:hover::after {
            width: 0;
        }

        nav ul li a::after {
            content: "";
            position: absolute;
            width: 0;
            height: 2px;
            background: #007bff;
            left: 50%;
            bottom: -4px;
            transition: width 0.3s ease, left 0.3s ease;
        }

        nav ul li a:hover::after {
            width: 100%;
            left: 0;
        }

        .profile {
            display: flex;
            align-items: center;
            position: absolute;
            right: 10px;
        }

        .profile a {
            margin-left: 1rem;
            color: #fff;
        }

        .profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            margin-left: 15px; /* Added gap between bell icon and profile image */
        }

        .fa-angle-down {
            margin-left: 0.5rem;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .fa-angle-down.active {
            transform: rotate(180deg);
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            width: 25px;
            height: 25px;
            position: relative;
            transition: transform 0.3s;
        }

        .hamburger div {
            width: 100%;
            height: 2px;
            background-color: white;
            margin: 3px 0;
            transition: all 0.3s;
            border-radius: 20px;
        }

        .hamburger.active {
            transform: rotate(180deg);
        }

        .hamburger.active div:nth-child(1) {
            transform: translateY(8px) rotate(45deg);
        }

        .hamburger.active div:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active div:nth-child(3) {
            transform: translateY(-8px) rotate(-45deg);
        }

        .dropdown-menu {
            position: absolute;
            right: 10px;
            top: 60px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            width: 190px;
            padding: 1rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .dropdown-menu.active {
            display: flex;
            flex-direction: column;
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu a {
            text-decoration: none;
            color: #333;
            padding: 0.5rem 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .dropdown-menu a:hover {
            color: #007bff;
            background-color: #003c3c;
            padding-left: 10px;
            border-radius: 4px;
            color: #fff;
        }

        @media (max-width: 760px) {
            nav ul {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 70px;
                left: 0;
                width: 100%;
                background-color: rgba(0, 60, 60, 0.9);
                padding: 10px;
                border-radius: 0;
                box-shadow: none;
                transition: background-color 0.3s ease;
                gap: 20px;
            }

            .hamburger.active + nav ul {
                display: flex;
                background-color: #003c3c;
            }

            .hamburger {
                display: flex;
            }

            .hamburger.active + nav ul {
                display: flex;
            }
        }

    </style>
</head>

<body>
    <header>
        <div class="hamburger" id="hamburger">
            <div></div>
            <div></div>
            <div></div>
        </div>
        <nav>
            <ul>
                <li>
                    <a href="../../App/View/scholar_home.php" class="sedp-link" style="display: flex; align-items: center;">
                        <?php include("svg.php"); ?>
                        <h4>SEDP HRMS</h4>
                    </a>
                </li>
                <li class="home <?php echo ($page === 'home') ? 'active' : ''; ?>">
                    <a href="../../App/View/scholar_home.php">Home</a>
                </li>
                <li class="scholar-compliance <?php echo ($page === 'scholarcompliance') ? 'active' : ''; ?>">
                    <a href="../../App/View/scholar_compliance.php">Scholar Compliance</a>
                </li>
            </ul>
            <div class="profile">
                <a href="../../App/View/notification.php"><i class="fa-solid fa-bell"></i></a>
                <img src="../../Public/Assets/Images/SEDPLogo.png" alt="Profile" id="profile-img">
                <i class="fa-solid fa-angle-down" id="dropdown-toggle"></i>
                <div class="dropdown-menu" id="dropdown-menu">
                    <a href="#"><i class="fa-solid fa-user"></i>&nbsp;Profile</a>
                    <a href="#"><i class="fa-solid fa-gear"></i>&nbsp;Settings</a>
                    <a href="./../../Assets/Php/logout.php"><i class="fa-solid fa-sign-out-alt"></i>&nbsp;Logout</a>
                </div>
            </div>
        </nav>
    </header>

    <script>
        // Dropdown toggle functionality
        const dropdownToggle = document.getElementById('dropdown-toggle');
        const profileImg = document.getElementById('profile-img');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const hamburger = document.getElementById('hamburger');

        function toggleDropdown() {
            dropdownToggle.classList.toggle('active');
            dropdownMenu.classList.toggle('active');
        }

        dropdownToggle.addEventListener('click', toggleDropdown);
        profileImg.addEventListener('click', toggleDropdown);

        // Hamburger toggle functionality for mobile
        hamburger.addEventListener('click', function () {
            hamburger.classList.toggle('active');
        });
    </script>

</body>

</html>
