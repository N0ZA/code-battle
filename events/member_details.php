<?php
    require_once "../includes/dbh.inc.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
        header("Location: index.php");
        exit();
    }
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
    if ($_SESSION['is_team']==1 && isset($_SESSION['TName'])){
        $query='SELECT T_id FROM team_data WHERE TName=:TName';
        $stmt = $pdo->prepare($query);
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
        if (!$solos) {
            header("Location: registered_events.php");
            exit(); 
            }    
    }    
    //get member details for solo event
    else{
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
    <title>Members</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="../css/styles.css">
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
                        <div class="card-front">
                            <div id="team-image">
                            <img src="<?php echo getImage(); ?>" alt="<?php echo $solo['PName']; ?>" class="team-img">
                        </div>
                            <div class="card-text">
                                <h3><strong><?php echo $solo['PName']; ?></strong></h3>   
                                <?php $C_id=$solo['C_id']; 
                                $CName = ($C_id==1)?'Jr_Cadet' : (($C_id==2)?'Jr_Captain' : (($C_id==3)?'Jr_Colonel' : 'Unknown'));?>
                            </div>
                        </div>
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
                            </div>  
                            <div class="card-actions">
                                <!--<?php if ($_SESSION['is_team']==0):?>
                                <a href="generate_ticket.php?team=<?php echo $team['TName']; ?>" class="icon-link"><i class="fas fa-ticket-alt"></i></a> 
                                <?php endif; ?>-->
                                <a href="eventedit.php?Solo=<?php echo $solo['P_id']; ?>&action=Sedit" class="icon-link" ><i class="fas fa-edit"></i></a>
                                <a href="javascript:void(0);" class="icon-link"  onclick="showModal('<?php echo $solo['PName']; ?>')"><i class="fas fa-trash"></i></a>   
                            </div>
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
            <p class="modal-text">Are you sure you want to delete member: <span id="solo-name"></span>?</p>
            <div class="modal-button-container">
                <button class="modal-button" onclick="hideModal()">Cancel</button>
                <button class="modal-button" onclick="Sdelete()">Yes</button>
            </div>
        </div>
    </div>
                
    <script>
        function showModal(teamName) {
            document.getElementById("solo-name").textContent = teamName;
            document.getElementById("modal").style.display = "flex";}

        function hideModal() {
            document.getElementById("modal").style.display = "none";}

        function Sdelete() {
            window.location.href = `eventedit.php?solo=${document.getElementById("solo-name").textContent}&action=Sdelete`;}
    </script>
</body>
</html>

    
