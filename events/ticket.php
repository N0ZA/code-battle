<?php
    require_once "../includes/dbh.inc.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
        header("Location: index.php");
        exit();
    }
    function getImage($eventImage) {
        $folder = '../Images/eventreg/';
        $imagePath = $folder . $eventImage;
        return $imagePath;
    }
    header("Content-Type: text/html; charset=UTF-8");
    $eventLocation = "Tech Village, Global Square, Abu Dhabi, UAE";

    if (isset($_GET['Ttick'])){
        $T_id=$_GET['Ttick'];
        $query='SELECT * from team_data WHERE T_id=:T_id AND Tuser_id=:user_id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id",$_SESSION['user_id']);
        $stmt->bindParam(":T_id",$T_id);
        $stmt->execute();
        $result=$stmt->fetch();
        $C_id=$result['C_id'];

        $query2='SELECT * from solo_data WHERE T_id=:T_id AND Puser_id=:user_id';
        $stmt2=$pdo->prepare($query2);
        $stmt2->bindParam(":user_id",$_SESSION['user_id']);
        $stmt2->bindParam(":T_id",$T_id);
        $stmt2->execute();
        $result2=$stmt2->fetchAll();
    }

    else if (isset($_GET['Stick'])){
        $P_id=$_GET['Stick'];
        $query='SELECT * from solo_data WHERE P_id=:P_id AND Puser_id=:user_id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id",$_SESSION['user_id']);
        $stmt->bindParam(":P_id",$P_id);
        $stmt->execute();
        $result=$stmt->fetch();
    }
    $CName =($result['C_id']==1)?'Jr_Cadet' : (($result['C_id']==2)?'Jr_Captain' : (($result['C_id']==3)?'Jr_Colonel' : 'Unknown'));
    $H_id=$result['H_id'];
    $query1='SELECT * from hackathon_data WHERE H_id=:H_id';
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindParam(":H_id",$H_id);
    $stmt1->execute();
    $result1=$stmt1->fetch();

    $eventTitle=$result1['HName'];
    $eventDate=$result1['HDate'];
    $eventTime=$result1['HTime'];
    $qrData = isset($_GET['Ttick']) ? 'T' . $_GET['Ttick'] : (isset($_GET['Stick']) ? 'P' . $_GET['Stick'] : '');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        window.addEventListener('load', function(){
            const preloader = document.querySelector('.preloader');
            preloader.style.display = 'none';
            generateQRCode();
        });

        function generateQRCode() {
            const qrData = "<?php echo $qrData; ?>";
            const qrCodeElement = document.getElementById("qrcode");
            qrCodeElement.innerHTML = ''; // Clear previous QR code if any
            new QRCode(qrCodeElement, {
                text: qrData,
                width: 80,
                height: 80
            });
        }
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
        .ticket-card {
            display: flex;
            width: 80%;
            max-width: 1200px;
            background-image: url("../Images/eventreg/event9.jpg");
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 0;
            margin: 0 auto; /* Center horizontally */
            border: 3px solid white;
            transition: height 0.3s ease, transform 0.3s ease;
        }

        .ticket-card:hover {
            transform: scale(1.05); /* Optional: add slight scale effect on hover */
            height: max-content;
        }

        .ticket-card .ticket-details {
            padding: 20px;
            flex: 2;
            position: relative;
            z-index: 3;
            color: white;
            overflow: hidden; /* Ensure content stays within bounds */
            flex-wrap: wrap;
            max-width: 80%;
        }

        .event-header {
            display: flex;
            align-items: center;
            margin-bottom: 10px; /* Space between header and date */
        }

        .event-name {
            font-family: Montserrat;
            margin: 0;
            font-size: 1.8em;
            font-weight: bold;
        }
        .event-date{
            font: Lalezar;
            font-weight: bold;
        }
        .event-time{
            display: flex;
            align-items: center;
        }
        .event-time span{
            margin-right: 10px;
        }
        .event-category, .event-info p {
            font: Lalezar;
            margin: 5px 0;
            font-size: 1.5em;
            font-weight: bold;
        }
        .contact{
            font: Lalezar;
            font-size: 1em;
            font-weight: bold;
            flex-wrap: wrap;
            max-width: 80%;
            margin:0;
        }
        .contact-info{
            padding: 0;
            margin-top: 0;
            display: flex;
            align-items: center;
        }
        .contact-info span{
            margin-right: 10px;
        }
        .ticket-image {
            position: relative;
            width: 300px;
            height: 100%;
            overflow: hidden;
            flex: 2;
        }

        .image-container {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensure the image covers the container */
        }

        .qr-code {
            position: absolute;
            bottom: 10px;
            right: 10px;
            width: 80px;
            height: 80px;
            background: #fff;
            border: 2px solid #ddd;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-code img {
            width: 60px;
            height: 60px;
        }
        .print-icon {
            position: absolute;
            bottom: 10px;
            right: 100px; /* Adjust this value to position it correctly */
            width: 30px;
            height: 30px;
            background: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .print-icon i {
            color: #333;
            font-size: 20px;
        }
        #pdfLink {
            display: none;
        }

        .slant, .slant-2, .slant-3 {
            position: absolute;
            width: 60%;
            height: 100%;
            clip-path: polygon(0 0, 100% 0, 80% 100%, 0 100%);
        }

        .slant {
            background: #f44134;
            top: 0;
            left: 0;
            z-index: 2;
        }

        .slant-2 {
            background: white;
            top: 0;
            left: 0;
            z-index: 1;
            transform: translateX(0.5%);
        }

        .slant-3 {
            background: #BE270E; /* Semi-transparent red */
            top: 0;
            left: 0;
            z-index: 3;
            transform: translateX(-100%); /* Start hidden off-screen */
            transition: transform 0.3s ease; /* Transition for smooth slide-in */
        }

        .ticket-card:hover .slant-3 {
            transform: translateX(0); /* Slide in on hover */
        }

        /* Optional: ensure content inside slant-3 is properly sized and centered */
        .slant-3 .ticket-details {
            padding: 20px;
            overflow: hidden; /* Ensure content does not overflow */
            flex-wrap: wrap;
            max-width: 80%;
        }

        .member-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
            columns: 2;
            column-gap: 10px;
        }

        .member-list li {
            background-color: #f8f8f8;
            margin: 3px 0;
            padding: 7px;
            border-radius: 5px;
            color: #333;
            max-width:max-content;
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

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
                    <!--<li><a href="../dashboard.php">Home</a></li>-->
                    <li><a href="../events/registered_events.php">Registered Events</a></li>
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
        <div class="ticket-card">
            <div class="ticket-details">
                <div class="event-header">
                    <img src="../images/codebattlelogo.png" alt="Logo" class="logo">
                    <h1 class="event-name"><?php echo $eventTitle; ?></h1>
                </div>
                <h2 class="event-date"><?php echo $eventDate; ?></h2>

                <div class="event-info">
                    <p class="event-category"> <?php echo $CName ?> </p>
                    <div class="event-time">
                        <span><i class="fa-solid fa-clock"></i></span>
                        <h1><?php echo $eventTime; ?></h1>
                    </div>
                    <h3><i class="fa-solid fa-location-dot"></i> <?php echo $eventLocation; ?></h3>
                </div>
            </div>
            <div class="ticket-image">
                <div class="image-container">
                    <img src="<?php echo getImage($result1['HImage']); ?>" alt="Event Image">
                    <div class="qr-code">
                        <div id="qrcode" class="qr-code-placeholder"></div>
                        <div class="print-icon" id="printButton"><i class="fas fa-print"></i> </div>
                    </div>
                </div>
            </div>
            <div class="slant"></div>
            <div class="slant-2"></div>
            <div class="slant-3">
                <div class="ticket-details">
                    <div class="event-header">
                        <img src="../images/codebattlelogo.png" alt="Logo" class="logo">
                        <?php if ($result1['is_team']==1): ?>
                            <h1 class="event-name">TEAM DETAILS</h1>
                        <?php elseif ($result1['is_team']==0): ?>
                            <h1 class="event-name">MEMBER DETAILS</h1>  
                        <?php endif ?>
                    </div>
                    <?php if ($result1['is_team']==1): ?>
                        <h3 class="event-date"> Team Name: <?php echo $result['TName'];?></h3> 
                        <h3 class="event-date"> School Name: <?php echo $result['TSchool'];?></h3> 
                        <h3 class="event-date">Members:</h3>
                        <?php if ($result2): ?>
                            <ul class="member-list">
                            <?php foreach ($result2 as $mem): ?>
                                <li><?php echo($mem['PName']); ?></li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p>No members found.</p>
                        <?php endif; ?>
                    <?php elseif ($result1['is_team']==0): ?>
                        <h3 class="event-date"> </h3> 
                        <h3 class="event-date"> Member Name: <?php echo $result['PName'];?></h3> 
                        <h3 class="event-date"> School Name: <?php echo $result['PSchool'];?></h3> 
                    <div class="contact">
                        <div class="contact-info">
                            <span><i class="fa-solid fa-envelope"></i></span>
                            <h3 class="event-date">Contact Info: <?php echo $result['PEmail'];?></h3>
                        </div>
                    </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>

    <a href="ticket.pdf" target="_blank" id="pdfLink" style="display:none;">Sample PDF</a>

    <script>
        document.getElementById('printButton').addEventListener('click', function() {
            window.open(document.getElementById('pdfLink').href, '_blank');
        });
    </script>
</body>
</html>
