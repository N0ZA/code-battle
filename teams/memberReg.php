<?php
    require_once '../includes/dbh.inc.php';
    require_once 'accept_team_data.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
        header("Location: ../index.php");
        exit();
    }
    $currentMember = $_SESSION['currentMember'];
    $noMembers = $_SESSION['noMembers'];

    // If the current member exceeds the total, redirect to a different page    
    if ($currentMember > $noMembers) {
        unset($_SESSION['noMembers']);
        unset($_SESSION['currentMember']);
        header("Location: ../dashboard.php"); // Redirect to a final page or completion page
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Registration</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url(https://github.com/N0ZA/code-battle/blob/main/Images/grids.jpeg?raw=true) no-repeat center center fixed;
            background-size: cover;
            overflow: hidden; /* Prevent scrolling while preloader is shown */
        }
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .loader {
            border: 8px solid #f3f3f3; /* Light grey */
            border-top: 8px solid #3498db; /* Blue */
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .content {
            opacity: 0; /* Initially hide content */
            transition: opacity 0.3s ease; /* Smooth transition for content visibility */
        }
        .loaded .content {
            opacity: 1; /* Show content after page load */
        }
        .navbar {
            background-color: #F73634;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            color: white;
            z-index: 10000; /* Ensure navbar is above preloader */
        }
        .navbar-brand {
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        .navbar-nav {
            display: flex;
        }
        .nav-link {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            cursor: pointer; /* Adding cursor pointer for links */
            transition: color 0.3s ease; /* Smooth transition for color change */
        }
        .nav-link.active {
            color: lightgray; /* Change color when link is active */
        }
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
            padding: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10000; /* Ensure form container is above preloader */
        }
        .form-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }
        .form-container h2 span {
            color: #F73634;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .form-group label {
            width: 80px;
            margin-right: 10px;
        }
        .form-group input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 20px;
            box-sizing: border-box;
        }
        button {
            background-color: #F73634;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 20px;
            cursor: pointer;
            margin-top: 10px;
        }
        footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 5px;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 12px;
            z-index: 10000; /* Ensure footer is above preloader */
        }

        footer p .heart {
            color: #F73634;
        }

    </style>
</head>
<body>
    <div class="preloader">
        <div class="loader"></div>
    </div>

    <div class="content">
        <nav class="navbar">
            <div class="navbar-brand">
                <img src="http://localhost/images/logob.png" alt="CodeBattle Image">
            </div>
            <div class="navbar-nav">
                <a href="#" class="nav-link" onclick="toggleActive(this)">View Hackathon</a>
                <a href="#" class="nav-link" onclick="toggleActive(this)">Edit Teams</a>
                <a href="#" class="nav-link" onclick="toggleActive(this)">Logout</a>
            </div>
        </nav>

        <div class="form-container">
            <h2>Enter <span>Member <?php echo $_SESSION['currentMember'];?> Details </span></h2>
            <form action="accept_member_data.php" method="POST">
                <div class="form-group">
                    <label for="Name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="school">School</label>
                    <input type="text" id="school" name="school" placeholder="Enter your school name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <button type="submit" name="Discard">Discard</button>
                <?php if ($currentMember < $noMembers): ?>
                    <button type="submit" name="Next">Next</button>
                <?php else: ?>
                    <button type="submit" name="Done">Done</button>
                <?php endif; ?>
            </form>
        </div>
        
        <footer>
            <p>Code Battle © 2024. All rights reserved. Made with <span class="heart">❤</span> in U.A.E</p>
            <p>Contact us at: info@codebattle.com</p>
        </footer>
    </div>
    
    <script>
        // Simulate page load
        window.addEventListener('load', function() {
            // Hide preloader
            const preloader = document.querySelector('.preloader');
            preloader.style.display = 'none';
            // Show content
            const content = document.querySelector('.content');
            content.style.opacity = '1'; // Ensure content is visible after load
        });

        function toggleActive(link) {
            // Toggle active class on the clicked link
            link.classList.toggle('active');
        }
    </script>
</body>
</html>
