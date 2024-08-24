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
        $query='SELECT * from team_data WHERE T_id=:T_id AND Tuser_id=:user_id and H_id=:H_id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id",$_SESSION['user_id']);
        $stmt->bindParam(":H_id",$_SESSION['H_id']); 
        $stmt->bindParam(":T_id",$T_id);
        $stmt->execute();
        $result=$stmt->fetch();
        $C_id=$result['C_id'];
        
        $query2='SELECT * from solo_data WHERE T_id=:T_id AND Puser_id=:user_id and H_id=:H_id';
        $stmt2=$pdo->prepare($query2);
        $stmt2->bindParam(":user_id",$_SESSION['user_id']);
        $stmt2->bindParam(":H_id",$_SESSION['H_id']); 
        $stmt2->bindParam(":T_id",$T_id);
        $stmt2->execute();
        $result2=$stmt2->fetchAll();
    
        if ($result['T_id']!=$T_id){
            header("Location: ../error404.html");
            exit();
        }
    }

    else if (isset($_GET['Stick'])){
        $P_id=$_GET['Stick'];
        $query='SELECT * from solo_data WHERE P_id=:P_id AND Puser_id=:user_id and H_id=:H_id AND T_id is NULL';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id",$_SESSION['user_id']);
        $stmt->bindParam(":H_id",$_SESSION['H_id']); 
        $stmt->bindParam(":P_id",$P_id);
        $stmt->execute();
        $result=$stmt->fetch();

        if ($result['P_id']!=$P_id){
            header("Location: ../error404.html");
            exit();
        }
    }

    $CName =($result['C_id']==1)?'Jr Cadet' : (($result['C_id']==2)?'Jr Captain' : (($result['C_id']==3)?'Jr Colonel' : 'Unknown'));
    $H_id=$result['H_id'];
    $query1='SELECT * from hackathon_data WHERE H_id=:H_id';
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindParam(":H_id",$H_id);
    $stmt1->execute();
    $result1=$stmt1->fetch();

    $eventTitle=$result1['HName'];
    $eventDate=$result1['HDate'];
    list($year, $month, $date) = explode('-', $eventDate);
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
        .ticket-container {
            display: flex;
            flex-direction: row;
            max-width: 80%;
            width: 1200px;
            margin:auto;
            background-color: #ff4545;
            color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.8);
            transition: transform 0.6s ease;
            border: 3px solid white;
        }

        .date-time-container {
            display: flex;
            height: 100%;
            flex-direction: column;
            justify-content: space-around;
            padding: 15px;
            background-color: #202020;
            width: 70px;
            text-align: center;
            border-right: 3px solid white;
        }

        .date-time-container .label {
            font-style: Lalezar;
            font-size: 20px;
           
        }

        .date, .month, .year {
            transform: rotate(90deg);
            margin: 10px 0;
        }

        .date span, .month span, .year span {
            display: block;
            font-size: 24px;
        }
        .time-container{
            display: flex;
            height: 100%;
            flex-direction: column;
            justify-content: space-around;
            padding: 15px;
            background-color: #202020;
            max-width: 40px;
            text-align: center;
            border-right: 3px solid white;
            overflow:hidden;
        }
        .time span{
            font-size: 24px;
            writing-mode: vertical-lr;
        }
        .event-details-container {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-right: 3px solid white;
        }

        .event-title h1 {
            margin: 0;
            font-size: 36px;
            text-transform: uppercase;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }

        .event-title p {
            margin: 10px 0 0;
            font-size: 18px;
            font-weight: bold;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .team-members {
            margin-top: 20px;
        }

        .team-members h2 {
            margin: 0 0 10px;
            font-size: 24px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
            font-weight: bold;
        }

        .team-members ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .team-members li {
            font-size: 18px;
            margin-bottom: 5px;
            font-weight: bold;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        }

        .qr-code-container {
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

        .qr-code-container img {
            width: 100px;
            height: 100px;
            object-fit: contain;

        }

        .image-container {
            max-width: 300px;
            height:100%; 
            position: relative;  
                     
        }
        .image-container img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            
        }
        .cd-logo{
            position:absolute;
            display:flex;
            top:0;
            right:10px;
            width:100px;
            height:50px;
            max-width: fit-content;
            margin-top: 20px;
            align-items: center;
            justify-content: center;
        }
        .cd-logo img{
            width: 100%;
            height: 100%;
            object-fit: contain;
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

        @media (max-width: 768px){
            .ticket-container{
                flex-direction: column-reverse;
            }
            .image-container{
                max-width: 100%;
                height: 300px;
            }
            .image-container img{
                border-bottom-left-radius: 15px;
                border-bottom-right-radius: 15px;
            }
            .event-details-container{
                flex: initial;
                border-right: none;
                border-bottom: 3px solid white;
            }
            .event-title h1{
                font-size: 23px;
            }
            .event-title p{
                font-size: 13px;
            }
            .team-members h2{
                font-size: 18px;
            }
            .team-members li{
                font-size: 13px;
            }
            .time-container{
                flex-direction: row;
                align-items: center;
                justify-content: center;
                max-width: 100%;
                height:40px;
                border-right: none;
                border-bottom: 3px solid white;
            }
            .time span{
                writing-mode:horizontal-tb;
            }
            .date-time-container{
                flex-direction: row;
                max-width: 100%;
                width: 100%;
                height: 70px;
                padding:10px;
                padding-left: 0;
            }
            .date-time-container .label{
                font-size: 18px;
            }
            .date, .month, .year {
                transform: rotate(0deg);
            }

            .date span, .month span, .year span {
                font-size: 20px;
            }
        }
        @media print {
            body {
                background: url(https://github.com/N0ZA/code-battle/blob/main/Images/grids.jpeg?raw=true) no-repeat center center fixed !important;
                background-size: cover !important;
            }

            .ticket-container {
                max-width: 100%;
                width: auto;
                margin: 0;
                height: auto;
                box-shadow: none;
                border: none;
            }

            .image-container img {
                width: 100%;
                height: auto;
                object-fit: cover;
                max-height: 100%;
            }

            .header, .preloader {
                display: none; /* Hide header and preloader when printing */
            }

            /* Ensure the content fits onto a single page */
            .ticket-container, .event-details-container, .image-container {
                page-break-inside: avoid;
                page-break-after: auto;
            }


            .print-icon {
                display: none; /* Hide print icon in the printout */
            }
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
                    <li><a href="../registered_events.php">Registered Events</a></li>
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

        <div class="ticket-container">   
            <div class="date-time-container">
                <div class="date">
                    <span class="label">Date</span>
                    <span class="day"><?php echo $date; ?></span>
                </div>
                <div class="month">
                    <span class="label">Month</span>
                    <span class="month-num"><?php echo $month; ?></span>
                </div>
                <div class="year">
                    <span class="label">Year</span>
                    <span class="year-num"><?php echo $year; ?></span>
                </div>
            </div>
            <div class="time-container">
                <div class="time">
                    <span class="time-range"><?php echo $eventTime; ?></span>
                </div>
            </div>
            
            <div class="event-details-container">
                <div class="event-title">
                    <h1><?php echo $eventTitle; ?></h1>
                    <?php if ($result1['is_team']==1): ?>
                        <p> Team Name: <?php echo ucfirst($result['TName']);?></p> 
                        <p> School Name: <?php echo $result['TSchool'];?></p> 
                    <?php elseif ($result1['is_team']==0): ?>
                        <p> Name: <?php echo $result['PName'];?></p> 
                        <p> School Name: <?php echo $result['PSchool'];?></p> 
                    <?php endif; ?>   
                    <p>Category: <?php echo $CName ?></p>
                    <p>Location: Tech Village, Global Square, Abu Dhabi</p>
                </div>

                <?php if ($result1['is_team']==1): ?>
                    <div class="team-members">
                        <h2>Team Members:</h2>
                            <?php if ($result2): ?>
                                <ul>
                                <?php foreach ($result2 as $mem): ?>
                                    <li><?php echo($mem['PName']); ?></li>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <p>No members found.</p>
                            <?php endif; ?>
                    </div>   
                <?php endif ?>           
            </div>
            <div class="image-container">
                <img src="<?php echo getImage($result1['HImage']); ?>" alt="Event-Image">
                <div class="cd-logo">
                    <img src="../images/codebattlelogo.png" alt="Logo">
                </div>
                <div class="print-icon" id="printButton"><i class="fas fa-print"></i> </div>
                <div id="qrcode" class="qr-code-container"> </div>
                
            </div>
            
        </div>

        <script>
            document.getElementById('printButton').addEventListener('click', function() {
                window.print();
            });
        </script>
</body>
</html>
