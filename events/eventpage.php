<?php
    declare(strict_types=1);

    require_once '../includes/dbh.inc.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
        header("Location: ../index.php");
        exit();
    }


header("Content-Type: text/html; charset=UTF-8");

    $eventLocation = "Digital Park, Silicon Oasis, Dubai, United Arab Emirates";
    $H_id=$_GET['H'];
    //get hackathon details
    $query='SELECT * FROM hackathon_data WHERE H_id=:H_id'; 
    $stmt=$pdo->prepare($query);
    $stmt->bindParam(":H_id",$H_id);
    $stmt->execute();
    $event=$stmt->fetch();

    $longDate=$event['HDate'];
    $date = new DateTime($longDate);
    $formatDate = $date->format('F j, Y');

    function getImage($eventImage) {
        $folder = '../Images/eventreg/';
        $imagePath = $folder . $eventImage;
        return $imagePath;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    
    <script>
        window.addEventListener('load', function(){
            const preloader = document.querySelector('.preloader');
            preloader.style.display = 'none';
        });
    </script>
    <style>
        @font-face {
            font-family: 'Montserrat';
            src: url('fonts/Montserrat/Montserrat-Regular.woff2') format('woff2'),
                 url('fonts/Montserrat/Montserrat-Regular.woff') format('woff'),
                 url('fonts/Montserrat/Montserrat-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'Lalezar';
            src: url('fonts/Lalezar/Lalezar-Regular.woff2') format('woff2'),
                 url('fonts/Lalezar/Lalezar-Regular.woff') format('woff'),
                 url('fonts/Lalezar/Lalezar-Regular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: Montserrat, Lalezar, sans-serif;
            background: url(https://github.com/N0ZA/code-battle/blob/main/Images/grids.jpeg?raw=true) no-repeat center center fixed;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding-top: 50px;
            color: #333;
            height: 100vh;
            background-color: #000000;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            flex: 1;
            padding-bottom: 70px;
            justify-content: center;
        }

        a {
            text-decoration: none;
        }

        input {
            display: none;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f44134;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .logo {
            height: 40px;
            margin-right: 20px;
        }

        .nav {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .nav li {
            display: inline;
            margin: 0 15px;
        }

        .nav li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .nav li a:hover {
            text-decoration: underline;
        }

        .header-right {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-right: 30px;
        }

        .profile-icon {
            height: 40px;
            cursor: pointer;
            padding-right: 30px;
        }

        .show {
            display: block;
        }

        .dropdown-container {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            background-color: #F73634;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown-container:hover .dropdown-content {
            display: block;
        }

        .event-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            position: relative;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 3px solid red;
            flex-wrap: wrap;
        }

        .event-image {
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 20px;
            width: 100%; 
            height: 350px;
            position: relative;
        }
        .event-image-blur {
            overflow: hidden;
            border-radius: 10px;
            width: 100%; 
            height: 100%;
            position: relative;
            backdrop-filter: blur(10px);
        }


        .event-image img {
            width: 100%;
            height: 100%;
            object-fit:contain; /* Ensures the image covers the container */
            transition: transform 0.3s ease-in-out;
        }

        .event-image img:hover {
            transform: scale(1.05);
        }
        
        .event-header {
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .event-header h1 {
            font-family: Montserrat;
            margin: 0;
            font-size: 2em;
            color: #333;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
        }
        
        .details-flex {
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
        }
        .event-details {
            flex:2;
            left: 0;
            padding-right: 10%;
        }
        .register-div {
            flex: 1;
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
            padding-right: 30px;
            position: relative;
        }
        @media (max-width: 768px) {
            .details-flex {
                flex-direction: column; 
            }

            .event-details {
                padding-right: 0; 
            }
            .register-div{
                justify-content:  center;
                padding: 0;
            }
            .event-container{
                margin-top: 25px;
            }

        }
        .event-date {
            font-size: 1.2em;
            color: #555;
            font-weight: bold;
        }

        .event-icons {
            display: flex;
            align-items: center;
            gap: 20px;

        }

        .event-icons button {
            background: #f44134;
            border: none;
            color: white;
            padding: 15px;
            border-radius: 50%;
            font-size: 1.5em;
            cursor: pointer;
            transition: background 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .event-icons button:hover {
            background: #fe0000;
        }

        .event-description {
            margin-bottom: 20px;
            font-size: 1.1em;
            color: #444;
            line-height: 1.6;
        }

        .event-timing {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 20px;
        }

        .timing-item {
            display: flex;
            align-items: center;
            background: #F3EDEC;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            flex: 1;
            max-width: 200px;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
            transition: ease-out 0.3s;
        }
        .timing-item:hover {
            color: white;
        }
        .timing-item::before{
            transition: 0.5s all ease;
            position: absolute;
            top:0;
            right: 50%;
            left: 50%;
            bottom: 0;
            opacity: 0;
            content: "";
            background-color: #f44134;
            border-radius: 4px;
        }
        .timing-item:hover:before{
            transition: 0.5s all ease;
            left: 0;
            right: 0;
            opacity: 1;
            z-index: -1;
        }

        .icon {
            margin-right: 10px;
            font-size: 1.5em;
            color: #007bff;
        }

        .event-location {
            padding: 20px;
            padding-top: 0;
            margin-bottom: 20px;
        }

        .event-location p {
            font-size: 1.1em;
            color: #333;
            margin: 0 0 10px;
        }

        .view-map-button {
            background-color: #f44134;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .view-map-button:hover {
            background-color: #BE270E;
        }

        .map-container {
            display: none; /* Initially hidden */
            height: 300px;
            border-radius: 5px;
            background: #ddd;
            overflow: hidden;
        }

        .map-container.visible {
            display: block; /* Show map */
        }

        .register-button {
            position: -webkit-sticky; /* For Safari */
            position: sticky;
            text-align: center;
            background-color: #f44134;
            color: #fff;
            border: none;
            padding: 15px 25px;
            border-radius: 8px;
            cursor: pointer;
            width: 120px;
            height:50px;
            box-shadow: inset 0 0 0 0 #BE270E, 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: ease-out 0.3s, transform 0.3s ease;
            font-size:medium;
        }

        .register-button:hover {
            
            box-shadow: inset 120px 0 0 0 #BE270E, 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-3px);
        }

        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #272727;
            color:#F73634;
            font-size: x-large;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loader {
            border: 8px solid #0000007c;
            border-top: 8px solid #F73634;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
        }
    </style>
</head>
<body>
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <div class="main-container">
        <div class="header">
            <div class="header-left">
                <img src="../images/codebattlelogo.png" alt="Logo" class="logo">
                <ul class="nav">
                    <li><a href="registered_events.php">Registered Events</a></li>
                </ul>
            </div>
            <div class="header-right">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                <div class="dropdown-container">
                    <button class="dropbtn"><i class="fas fa-user"></i>&#x25BC;</button>
                    <div id="profile-dropdown" class="dropdown-content">
                        <a onclick="window.location.href='../logout.php';">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="event-container">
            <!-- Event Image -->
            <div class="event-image" style="background-image: url('<?php echo getImage($event['HImage']); ?>');">
                <div class="event-image-blur">
                    <img src="<?php echo getImage($event['HImage']); ?>" alt="Event Image">
                </div>
            </div> 

            <!-- Event Details -->
            <div class="event-header">
                <h1><?php echo $event['HName']; ?></h1>
                <div class="event-icons">
                    <button class="share-button" title="Share">
                        <i class="fas fa-share"></i>
                    </button>
                    <!--<button class="wishlist-button" title="Add to Wishlist">
                        <i class="fa-solid fa-heart"></i>
                    </button> -->
                </div>
            </div>
            <div class="details-flex">

                <div class="event-details">
                    
                    <p class="event-date"><?php echo $formatDate; ?></p>
    
                    <div class="event-description">
                        <p><?php echo $event['Hdesc']; ?></p>
                    </div>
    
                    <div class="event-timing">
                        <div class="timing-item">
                            <span class="icon">🕒</span>
                            <p><?php echo $event['HTime']; ?></p>
                        </div>
                        <!-- Add more timing items if needed -->
                    </div>
    
                </div>
                <div class="register-div">
                <form action="eventreg.php" method="POST">
                    <input type="hidden" name="H_id" value="<?php echo $event['H_id']; ?>">
                    <input type="hidden" name="is_team" value="<?php echo $event['is_team']; ?>">
                    <button type="submit" class="register-button">Register</button>
                </div>
            </div>
            <div class="event-location">
                <h2><i class="fa-solid fa-location-dot"></i> Location (LOCATIONNNN PLSSS)</h2>
                <p><?php echo $eventLocation ?></p>
                <button class="view-map-button" id="map-toggle-button" onclick="toggleMap()">View Map</button>
                <div class="map-container" id="map-container">
                    <!-- Embed Google Map or other map service here -->
                    <iframe src="https://www.google.com/maps/embed?...your-map-query..." width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleMap() {
            const mapContainer = document.getElementById('map-container');
            const mapButton = document.getElementById('map-toggle-button');

            if (mapContainer.classList.contains('visible')) {
                mapContainer.classList.remove('visible');
                mapButton.textContent = 'View Map';
            } else {
                mapContainer.classList.add('visible');
                mapButton.textContent = 'Close Map';
            }
        }
    </script>
</body>
</html>
