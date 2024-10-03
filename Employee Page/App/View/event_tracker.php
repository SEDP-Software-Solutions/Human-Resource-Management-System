<?php 
$title = 'Employee Event Tracker | SEDP HRMS';
$page = 'employeeHome';
include('../../Core/Includes/eventTrackerHeader.php'); // Include header without calendar setup
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.6/index.global.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #A6A6A6; 
        }
        .dashboard-card {
            background-color: #ffffff; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
            padding: 20px; 
            margin-bottom: 20px;
        }
        .section-title {
            color: #003c3c; 
            font-weight: bold;
            font-size: 20px; 
        }
        .calendar-title {
            font-size: 24px; 
            font-weight: bold;
            margin-bottom: 15px; 
            color: #003c3c; 
        }
        .fc-daygrid-day, .fc-daygrid-day-number {
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="container p-4 shadow-lg bg-white rounded" style="margin-top: 5.5rem;">
    <div class="row">
        <!-- Calendar Section -->
        <div class="col-md-4">
            <div class="dashboard-card">
                <h5 class="calendar-title">Your Calendar</h5>
                <div id="calendar" class="event-calendar" style="height: 400px;"></div>
            </div>
        </div>

        <!-- Task List Section -->
        <div class="col-md-8">
            <div class="dashboard-card">
                <h5 class="section-title">Upcoming Tasks</h5>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Project A</strong>
                        <p>Deadline: October 10, 2024</p>
                    </li>
                    <li class="list-group-item">
                        <strong>Project B</strong>
                        <p>Deadline: October 15, 2024</p>
                    </li>
                    <li class="list-group-item">
                        <strong>Team Meeting</strong>
                        <p>Date: October 20, 2024</p>
                    </li>
                </ul>
                <button class="btn btn-primary mt-3">Add New Task</button> 
            </div>
        </div>
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
            <a href="https://x.com/MfiSedp" class="mx-2 text-light"><i class="fa fa-twitter"></i></a>
            <a href="https://www.youtube.com/channel/UCJ_gLJ3LBM8x6CE1R9zGg9Q" class="mx-2 text-light"><i class="fa fa-youtube"></i></a>
            <a href="https://www.instagram.com/sedp.mfi/" class="mx-2 text-light"><i class="fa fa-instagram"></i></a>
        </div>
    </div>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.6/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: '',
                center: 'title',
                right: ''
            },
            events: [
                {
                    title: '', 
                    start: '2024-10-10', 
                    color: '#ff9f00'
                },
                {
                    title: '', 
                    start: '2024-10-15', 
                    color: '#ff0000' 
                },
                {
                    title: '', 
                    start: '2024-10-20T10:30:00', 
                    end: '2024-10-20T12:30:00',
                    color: '#007bff'
                }
            ],
            showNonCurrentDates: false,
            height: '100%', 
            contentHeight: 'auto',
            aspectRatio: 1.5,
            dayMaxEvents: true, 
        });
        calendar.render(); 
    });
</script>
</body>
</html>
