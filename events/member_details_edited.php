<?php
    require_once "../includes/dbh.inc.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
        header("Location: index.php");
        exit();
    }
    unset($_SESSION['new_TM']);
    function getImage($Folder = '../Images/teams/') {
        static $lastImage=-1; //static allows it to retain the value during function calls
        $images=glob($Folder.'*.{jpg,jpeg,png,gif}', GLOB_BRACE); 
        sort($images);
        $lastImage=($lastImage+1) % count($images);
        return $images[$lastImage];
    }
    //get user details
    $query='SELECT RName FROM registration_data WHERE R_id = :user_id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id",$_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->fetch();
    //get member details for a team
    //if (!isset($_SESSION["is_team"]) || (!isset($_SESSION['TName']))) {
      //  header("Location: registered_events.php");
      //  exit(); 
      //  }    
    if ($_SESSION['is_team']==1 && isset($_SESSION['TName'])){
        $query='SELECT T_id FROM team_data WHERE H_id=:H_id and Tuser_id=:user_id and TName=:TName';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":user_id",$_SESSION['user_id']);
        $stmt->bindParam(":H_id",$_SESSION['H_id']);   
        $stmt->bindParam(":TName",$_SESSION['TName']);
        $stmt->execute();
        $result=$stmt->fetch();
        $T_id=$result['T_id'];

        $query1='SELECT * FROM solo_data WHERE H_id=:H_id and Puser_id=:user_id and T_id=:T_id';
        $stmt1=$pdo->prepare($query1);
        $stmt1->bindParam(":T_id", $T_id); //tname has T_id from eventedit.php link
        $stmt1->bindParam(":user_id",$_SESSION['user_id']);
        $stmt1->bindParam(":H_id",$_SESSION['H_id']);   
        $stmt1->execute();
        $solos=$stmt1->fetchAll();
    }    
    //get member details for solo event
    else if ($_SESSION['is_team']==0){
        $query1='SELECT * FROM solo_data WHERE H_id=:H_id and Puser_id=:user_id and T_id IS NULL';
        $stmt1=$pdo->prepare($query1);
        $stmt1->bindParam(":user_id",$_SESSION['user_id']);
        $stmt1->bindParam(":H_id",$_SESSION['H_id']);   
        $stmt1->execute();
        $solos=$stmt1->fetchAll();
    }
    $query2 ='SELECT * FROM hackathon_data WHERE H_id = :H_id';
    $stmt2 = $pdo->prepare($query2);
    $stmt2->bindParam(':H_id', $_SESSION['H_id']);
    $stmt2->execute();
    $Hdetails=$stmt2->fetch();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <style>
        @font-face {
            font-family: 'Montserrat';
            src: url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: url('https://github.com/N0ZA/code-battle/blob/main/Images/grids.jpeg?raw=true') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding-top: 50px;
            color: #fff;
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
            list-style: none;
            display: flex;
            padding: 0;
            margin: 0;
        }

        .nav li {
            margin: 0 10px;
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

        .dropdown-container {
            position: relative;
        }

        .dropbtn {
            background-color: #f44134;
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

        .welcome-container {
            padding: 10px 20px;
            width: 100%;
            box-sizing: border-box;
        }

        .welcome {
            text-align: left;
            color: black;
            text-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
        .username {
            color: #f44134;
        }

        .footer {
            display: flex;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            justify-content: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            left: 0;
            max-height: fit-content;
        }

        /* team details cards */
        .teams-title {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 10px;
            margin: auto;
            width: 40%;
            font-size: larger;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            text-align: center;
            color: black;
        }
        .team-card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .team-card {
            width: 300px;
            height: 400px;
            cursor: pointer;
            position: relative;
            border-radius: 15px;
            margin: 10px;
        }

        .team-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.8);
            border-radius: 15px;
        }

        .card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
        }

        .team-card:hover .card-inner {
            transform: scale(1.05)
        }



        .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 16px;
        }


        .card-back {
            background: #f44134;
            color: white;
        }

        .card-members {
            padding: 20px;
            height: 66%;
        }

        .member-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .member-list li {
            background-color: #f8f8f8;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
            color: #333;
        }

        .card-actions {
            height: 33%;
            display: flex;
            justify-content:space-around;
            align-items: center;
            padding-bottom: 15px;
            margin-bottom: 10px;

        }

        .card-actions .icon-link {
            color: white;
            text-decoration: none;
            font-size: 1.5em;
            cursor: pointer;
        }

        .card-actions .icon-link:hover {
            color: #ddd; /* Change color on hover for better UX */
        }

        .modal-background {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            position: absolute;
            font-weight: bold;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgb(255, 255, 255);
            padding: 20px;
            border-radius: 1rem;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            text-align :center;
        }

        .modal-content p{
            margin-top: 1rem;
        }
        .modal-text {
            margin-bottom: 20px;
        }

        .modal-button-container button {
        background-color: #000000;
            border: 1px;
            border-radius: 25px;
            color: #ffffff;
            font-size: 1rem;
            padding: 0.5rem;
            width: 25%;
            margin-top:1rem;  
        }

        .modal-button-container button:hover {
        background-color: #DF2724; 
        }

        .modal-button:first-child {
        margin-right: 1rem;
        }

        .modal-button:last-child {
        margin-left: 1rem; 
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

        /* Media Queries */
        @media (max-width: 768px) {
            .header, .footer {
                text-align: center;
            }

            .header-left, .header-right {
                margin-bottom: 10px;
            }

            .nav li {
                display: flexbox;
                padding: 10px;
                margin: 5px 0;
            }

            .welcome-container, .content {
                padding: 20px;
            }

            .about-us-card, .carousel-title {
                width: 80%;
            }

            .events-card {
                width: 90%;
                margin: 10px 0;
            }

            .cards {
                width: 90%;
            }

            .events-carousel {
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .logo {
                height: 30px;
            }

            .profile-icon {
                height: 30px;
            }

            .nav li a {
                font-size: 14px;
            }

            .about-us-card, .events-title {
                width: 90%;
            }

            .events-card {
                width: 100%;
            }

            .cards {
                width: 100%;
            }
        }

    </style>
    <script>
        /*function toggleDropdown() {
            document.getElementById("profile-dropdown").classList.toggle("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('.profile-icon')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }*/

        window.addEventListener('load', function(){
            const preloader = document.querySelector('.preloader');
            preloader.style.display = 'none';
        });
    </script>
    <style>
        
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
        <!--    <li><a href="../dashboard.php">Home</a></li>   -->
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
            <!--<img src="images/profile-icon.png" alt="Profile" class="profile-icon" onclick="toggleDropdown()">
            <div id="profile-dropdown" class="dropdown-content">
                <a href="#">Logout</a> 
            </div>-->
        </div>
    </div>
    <div class="welcome-container">
        <div class="welcome">
            <h1>Welcome, <span class="username"><?php echo $user['RName']; ?></span></h1>
        </div>
    </div>   
    <div class="teams-title">
        <?php if ($_SESSION['is_team']==1): ?><h2>Edit Members </h2> 
        <?php else: ?> <h2>Registered Members </h2> <?php endif ?>  
        <h4>Hackathon: <span class="username"><?php echo $Hdetails['HName'];?> </span>
        <?php if ($_SESSION['is_team']==1): ?>Team: <span class="username"><?php echo $_SESSION['TName'];  endif ?>  </span></h4>
    </div>
        <div class="team-card-container">
        <?php 
        if (!empty($solos)): ?>
           <?php $memCount = 1;
            foreach ($solos as $solo): ?>
                <div class="team-card" id="<?php echo $solo['PName']; ?>" onclick="CardClick(this)">
                    <div class="card-inner">
                        <!--<div class="card-front">
                            <div id="team-image">
                            <img src="<?php echo getImage(); ?>" alt="<?php echo $solo['PName']; ?>" class="team-img">
                        </div>
                            <div class="card-text">
                                <h3><strong><?php echo $solo['PName']; ?></strong></h3>   
                                <?php $C_id=$solo['C_id']; 
                                $CName = ($C_id==1)?'Jr_Cadet' : (($C_id==2)?'Jr_Captain' : (($C_id==3)?'Jr_Colonel' : 'Unknown'));?>
                            </div>
                        </div>-->
                        <div class="card-back">
                            <div class="card-members">
                                <?php if ($solo['T_id']==NULL): ?>
                                    <p> MEMBER DETAILS</p>
                                <?php else: ?>
                                    <p> MEMBER <?php echo $memCount; ?> DETAILS</p>
                                <?php endif; ?>
                                    <ul class="member-list">
                                        <li>Name: <?php echo $solo['PName']; ?></li>
                                        <li>Category: <?php echo $CName; ?></li>
                                        <li>Email: <?php echo $solo['PEmail']; ?></li>
                                        <li>School: <?php echo $solo['PSchool']; ?></li>
                                    </ul>
                                    <?php if ($solo['Pchecked_in']==0): ?> 
                                        <?php if ($_SESSION['is_team']==0):?>
                                            <div class="card-actions">
                                                <a href="../ticket_and_qr/ticket.php?Stick=<?php echo $solo['P_id']; ?>" class="icon-link" style="font-size:20px;">
                                                <i class="fas fa-ticket-alt"></i> Download Ticket</a> 
                                            </div>  <?php endif; ?>
                                    <?php endif; ?>
                            </div>  
                            <?php if ($solo['Pchecked_in']==0): ?> 
                                <div class="card-actions">
                                    <a href="eventedit.php?Solo=<?php echo $solo['P_id']; ?>&action=Sedit" class="icon-link" ><i class="fas fa-edit"></i></a>
                                    <a href="javascript:void(0);" class="icon-link"  onclick="showModal('<?php echo $solo['P_id']; ?>')"><i class="fas fa-trash"></i></a>    
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php $memCount++; ?>
            <?php endforeach; ?>
            <?php else: ?>
                <p>You have not registered any members yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <div id="modal" class="modal-background">
        <div class="modal-content">
            <p class="modal-text">Are you sure you want to delete the member?</p>
            <div class="modal-button-container">
                <button class="modal-button" onclick="hideModal()">Cancel</button>
                <button class="modal-button" onclick="Sdelete()">Yes</button>
            </div>
        </div>
    </div>
                
    <script>
        let currentSoloID = '';
        function showModal(soloID) {
            currentSoloID = soloID;
            document.getElementById("modal").style.display = "flex";}

        function hideModal() {
            document.getElementById("modal").style.display = "none";}

        function Sdelete() {
            window.location.href = `eventedit.php?solo=${currentSoloID}&action=Sdelete`;}
    </script>
</body>
</html>

    
