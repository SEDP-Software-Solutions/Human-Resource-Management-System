<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("location:../../index.php");
    exit();
}

$username = $_SESSION['username'];
if (strpos($username, '@') !== false) {
    $username = explode('@', $username)[0];
}


$possibleNames = preg_split('/[._]/', $username);

if (preg_match('/([a-z]+)([A-Z][a-z]+)/', $username)) {

    $firstName = preg_replace('/([a-z])([A-Z])/', '$1 $2', $username);
    $firstName = explode(' ', $firstName)[0];
} elseif (count($possibleNames) > 1) {

    $firstName = $possibleNames[0];
} else {

    $firstName = $username;
}


$firstName = ucfirst(strtolower($firstName));



$title = 'Scholar Home | SEDP HRMS';
$page = 'home';
include('../../Core/Includes/header.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

    <head>
        <!-- Other head elements -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

        <!-- Calendar cdn-->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.6/index.global.min.css" rel="stylesheet">
    </head>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

        body {
            background-color: #f8f9fa;
            font-family: 'Roboto', sans-serif;
        }

        /* Card styles with hover effect */
        .dashboard-card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .dashboard-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        span {
            font-family: 'Roboto', sans-serif;
        }

        .section-title {
            color: #003c3c;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 1.25rem;
        }

        .welcome-message {
            font-size: 1.5rem;
            color: #003c3c;
            padding: 13px 30px;
            text-align: center;
            background: linear-gradient(to right, #003c3c, #005f5f);
            color: white;
            border-radius: 5px;
        }

        .icon-section-title {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-section-title i {
            color: #003c3c;
            font-size: 1.5rem;
        }

        .btn-custom {
            background-color: #003c3c;
            color: white;
            border-radius: 5px;
        }

        .btn-custom:hover {
            background-color: #005f5f;
        }

        .progress-bar {
            background-color: #003c3c;
        }

        .event-calendar {
            height: 200px;
            background-color: #eaeaea;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .event-calendar:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 10px;
            background: #003c3c;
            bottom: 0;
            left: 0;
            transform: translateY(100%);
            animation: slide-up 0.5s forwards;
        }

        @keyframes slide-up {
            to {
                transform: translateY(0);
            }
        }

        .bg-light-violet {
            background-color: #f4f0ff;
        }

        .custom-card-header {
            background-color: #C2EEFF;
            border-radius: 5px 5px 0 0;
            padding: 10px;
        }

        .custom-list-group-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .custom-list-group-item i {
            color: #003c3c;
            background-color: #fff;
        }

        /* Floating announcement title */
        .floating-announcement {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #003c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            z-index: 1;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .admin-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            .welcome-message {
                text-align: center;
            }
        }

        .fc-toolbar-title {
            display: block;
            text-align: center;
            color: #fff;
        }

        #calendar {
            height: auto;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
        }

        .fc .fc-scrollgrid {
            border: 1px solid #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        .fc-day-other {
            display: none;
        }

        .fc-daygrid-day {
            padding: 0;
            background-color: #003c3c;
            border-color: #666;
        }

        .fc-day-today {
            background-color: #FFDD00;
            color: #000;
        }

        .fc-toolbar-title {
            display: block;
            text-align: center;
            color: #fff;
            font-size: 1rem;
        }

        .fc .fc-col-header-cell-cushion {
            color: #fff;
            text-decoration: none;
            font-size: 12px;
        }

        .fc .fc-daygrid-day-number {
            color: #fff;
            text-decoration: none;
            display: inline-block;
            width: 15px;
            height: 15px;
            line-height: 25px;
            border-radius: 50%;
            text-align: center;
        }

        .fc .fc-daygrid-body-natural {
            margin-bottom: -25px;
        }

        .fc .fc-daygrid-body-natural .fc-daygrid-day-events {
            margin: 0;
            padding: 0;
        }

        .fc-daygrid-day-top {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .fc .fc-daygrid-body-unbalanced .fc-daygrid-day-events {
            min-height: 2.6em;
            position: relative;
        }

        .fc .fc-daygrid-week-header th {
            color: #fff;
            font-size: 16px;
            text-decoration: none;
        }

        .fc-day-sun,
        .fc-day-other {
            background-color: #004d4d;
        }

        .fc-event,
        .fc-event-title {
            color: #fff;
        }

        .fc-daygrid-day-number,
        .fc-daygrid-day-events {
            font-size: 10px;
        }

        .fc-day-today {
            background-color: #FFDD00;
            color: #000;
        }

        .fc .fc-daygrid-body tr:last-child {
            visibility: visible;
            height: auto;
        }

        .fc .fc-daygrid-day-frame {
            border-bottom: 1px solid #fff;
            height: 100%;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row" style="margin-top: 5.5rem;">
            <div class="col-md-4">
                <div class="dashboard-card">
                    <div class="icon-section-title">
                        <i class="lni lni-graduation"></i>
                        <span style="font-weight: 700; font-size: 25px;">Good Day, <?php echo $firstName; ?>!</span>
                    </div>
                    <span style="padding-left: 2.3rem; font-weight: 600; font-size: 16px;">Welcome Back!</span>
                </div>

                <div class="dashboard-card">
                    <h5 class="section-title">Academic Performance Overview</h5>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100">80%</div>
                    </div>
                    <p class="mt-2">GPA: 3.8 / 4.0</p>
                </div>

                <div class="dashboard-card">
                    <h5 class="section-title">Calendar</h5>
                    <div id="calendar" class="event-calendar" style="background-color: #003c3c; color: #fff;"></div>
                </div>

            </div>

            <div class="col-md-8">
                <div class="dashboard-card" style="height: 330px; position: relative;">
                    <div class="custom-card-header bg-white shadow rounded border-dark">
                        <div class="admin-profile">
                            <img src="../../Public/Assets/Images/profile.jpg" alt="Admin Profile"> <!-- Replace with actual image path -->
                            <div>
                                <strong style="font-size: 20px;">System Administrator</strong><br>
                                <small class="text-muted" style="font-size: 10px;">1 minute ago</small>
                            </div>
                        </div>
                        <span class="floating-announcement">Announcement</span>
                    </div>
                    <div class="announcement shadow rounded p-2 mt-3 bg-white">
                        <p>Upcoming seminar on career development on October 5th.</p>
                        <p>Financial aid disbursement due on October 10th.</p>
                    </div>
                </div>

                <div class="dashboard-card">
                    <h5 class="section-title">INC Requirements Tracker</h5>
                    <ul class="list-group">
                        <li class="list-group-item custom-list-group-item">Submit transcript <i class="fas fa-check-circle"></i></li>
                        <li class="list-group-item custom-list-group-item">Register for courses <i class="fas fa-check-circle"></i></li>
                        <li class="list-group-item custom-list-group-item">Schedule advisor meeting <i class="fas fa-check-circle"></i></li>
                        <li class="list-group-item custom-list-group-item">Submit transcript <i class="fas fa-check-circle"></i></li>
                        <li class="list-group-item custom-list-group-item">Register for courses <i class="fas fa-check-circle"></i></li>
                        <li class="list-group-item custom-list-group-item">Schedule advisor meeting <i class="fas fa-check-circle"></i></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-12 shadow rounded p-4 mb-4" style="background-color: #f0f9f9;">
            <h5 class="text-center" style="color: #003c3c; font-weight: bold; letter-spacing: 1px;">User Activity Over Time</h5>
            <canvas id="userActivityChart"></canvas>
        </div>

    </div>
    <div class="container-fluid bg-dark text-center text-light" style="padding: 10px 0;">
        <div class="footer-content" style="min-height: 100px; line-height: 30px;">
            <p class="mb-2">&copy; 2024 Your Organization. All Rights Reserved.</p>

            <ul class="list-inline mb-2">
                <li class="list-inline-item"><a href="https://sedp.ph/about-us/" class="text-light">About Us</a></li>
                <li class="list-inline-item"><a href="https://sedp.ph/services/" class="text-light">Services</a></li>
                <li class="list-inline-item"><a href="/privacy-policy" class="text-light">Privacy Policy</a></li>
                <li class="list-inline-item"><a href="/terms-of-service" class="text-light">Terms of Service</a></li>
            </ul>

            <p class="mb-2">Contact Us: <a href="mailto:simbag_sedp@yahoo.com" class="text-light">simbag_sedp@yahoo.com</a></p>

            <div class="social-media-links mb-2">
                <a href="https://web.facebook.com/sedp.ph" target="_blank" class="mx-2 text-light"><i class="fa fa-facebook"></i></a>
                <a href="https://twitter.com/yourprofile" class="mx-2 text-light"><i class="fa fa-twitter"></i></a>
                <a href="https://linkedin.com/in/yourprofile" class="mx-2 text-light"><i class="fa fa-linkedin"></i></a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.6/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var ctx = document.getElementById('userActivityChart').getContext('2d');
        var gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(0, 60, 60, 0.5)');
        gradient.addColorStop(1, 'rgba(0, 60, 60, 0.1)');

        var userActivityChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Active Users',
                    data: [12, 19, 3, 5, 2, 3, 18, 12, 22, 9, 15, 25],
                    backgroundColor: gradient,
                    borderColor: '#003c3c',
                    borderWidth: 3,
                    pointBackgroundColor: '#003c3c',
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month',
                            color: '#003c3c',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        ticks: {
                            color: '#003c3c'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Active Users',
                            color: '#003c3c',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        },
                        beginAtZero: true,
                        ticks: {
                            color: '#003c3c'
                        },
                        grid: {
                            color: 'rgba(0, 60, 60, 0.1)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#003c3c',
                            font: {
                                weight: 'bold'
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: '#003c3c',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        titleFont: {
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 12
                        }
                    }
                }
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: '',
                    center: 'title',
                    right: ''
                },
                titleFormat: {
                    month: 'long',
                    year: 'numeric'
                },
                events: [{
                        title: 'Event 1',
                        start: '2024-10-01'
                    },
                    {
                        title: 'Event 2',
                        start: '2024-10-05',
                        end: '2024-10-07'
                    },
                    {
                        title: 'Meeting',
                        start: '2024-10-12T10:30:00',
                        end: '2024-10-12T12:30:00'
                    }
                ],
                showNonCurrentDates: false,
                height: '100%',
                contentHeight: 'auto',
                aspectRatio: 1.5,
                dayMaxEvents: true,
                weekends: true
            });
            calendar.render();
        });
    </script>


    </script>
</body>

</html>