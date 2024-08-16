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

    //get team details
    if ($_SESSION['is_team']==1){
        $query1='SELECT * FROM team_data WHERE H_id=:H_id and Tuser_id=:user_id';
        $stmt1=$pdo->prepare($query1);
        $stmt1->bindParam(":user_id",$_SESSION['user_id']);
        $stmt1->bindParam(":H_id",$_SESSION['H_id']);
        $stmt1->execute();
        $teams=$stmt1->fetchAll();
    }
    else{
        header('Location:registered_events.php');
    }
    $query2 ='SELECT * FROM hackathon_data WHERE H_id = :H_id';
    $stmt2 = $pdo->prepare($query2);
    $stmt2->bindParam(':H_id', $_SESSION['H_id']);
    $stmt2->execute();
    $Hdetails=$stmt2->fetch();

     //deleting teams tht have  less than 2 members
     foreach ($teams as $team) {
        if ($team['TMembers']<2){
            $query4='DELETE FROM team_data WHERE T_id=:T_id';
            $stmt4=$pdo->prepare($query4);
            $stmt4->bindParam(":T_id",$team['T_id']);
            $stmt4->execute();
            unset($_SESSION['TName']);
        }
    }
    //get the team details again after updating
    $stmt1->execute();
    $teams=$stmt1->fetchAll();   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teams</title>
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
        <h2>Registered Teams</h2> <h4>Hackathon: <span class="username"><?php echo $Hdetails['HName']; ?></h4></span>
    </div>
     <div class="team-card-container">
        <?php if (!empty($teams)): ?>
           <?php foreach ($teams as $team): ?>
                <?php 
                     $query3 = 'SELECT * FROM solo_data WHERE H_id=:H_id and Puser_id=:user_id and T_id=:T_id';
                     $stmt3 = $pdo->prepare($query3);
                     $stmt3->bindParam(":user_id", $_SESSION['user_id']);
                     $stmt3->bindParam(":H_id", $_SESSION['H_id']);
                     $stmt3->bindParam(":T_id", $team['T_id']);
                     $stmt3->execute();
                     $members = $stmt3->fetchAll();
                ?>
                <div class="team-card" id="<?php echo $team['TName']; ?>" onclick="CardClick(this)">
                    <div class="card-inner">
                        <div class="card-front">
                            <div id="team-image">
                            <img src="<?php echo getImage(); ?>" alt="<?php echo $team['TName']; ?>" class="team-img">
                        </div>
                            <div class="card-text">
                                <h3><strong><?php echo $team['TName'], $team['Tchecked_in'];; ?></strong>
                                <?php $C_id=$team['C_id']; 
                                $CName = ($C_id==1)?'Jr_Cadet' : (($C_id==2)?'Jr_Captain' : (($C_id==3)?'Jr_Colonel' : 'Unknown'));
                                ?></h3>
                                
                            </div>
                        </div>
                        <div class="card-back">
                            <div class="card-members">
                                <p>MEMBERS  (<?php echo $CName; ?>)</p>
                                <ul class="member-list">
                                    <?php if (!empty($members)): ?>
                                        <?php foreach ($members as $member): ?>
                                            <li><?php echo $member['PName']; ?></li>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <p>You have not registered any members for this team.</p>
                                    <?php endif; ?>
                                </ul>
                                <?php if ($team['Tchecked_in']==0): ?> 
                                    <div class="card-actions">
                                        <a href="generate_ticket.php?tick=<?php echo $team['T_id']; ?>" class="icon-link" style="font-size:20px;">
                                        <i class="fas fa-ticket-alt"></i> Download Ticket </a> 
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="card-actions">
                                <?php if ($team['Tchecked_in']==0): ?> 
                                    <?php 
                                        if ($Hdetails[$CName]==0 || $team['TMembers']==$Hdetails['MaxP']): ?>
                                            <a href="eventedit.php?team=<?php echo $team['TName']; ?>&action=edit" class="icon-link" ><i class="fas fa-edit"></i></a>
                                            <a href="javascript:void(0);" class="icon-link"  onclick="showModal('<?php echo $team['TName']; ?>')"><i class="fas fa-trash"></i></a>
                                    <?php else: ?>
                                        <a href="eventedit.php?team=<?php echo $team['TName']; ?>&action=add" class="icon-link" ><i class="fas fa-plus"></i></a>
                                        <a href="eventedit.php? team=<?php echo $team['TName']; ?>&action=edit" class="icon-link" ><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0);" class="icon-link"  onclick="showModal('<?php echo $team['TName']; ?>')"><i class="fas fa-trash"></i></a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php else: ?>
                <p>You have not created any teams yet.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <div id="modal" class="modal-background">
        <div class="modal-content">
            <p class="modal-text">Are you sure you want to delete team: <span id="team-name"></span>?</p>
            <div class="modal-button-container">
                <button class="modal-button" onclick="hideModal()">Cancel</button>
                <button class="modal-button" onclick="Tdelete()">Yes</button>
            </div>
        </div>
    </div>
  
    <script>
        function showModal(teamName) {
            document.getElementById("team-name").textContent = teamName;
            document.getElementById("modal").style.display = "flex";}

        function hideModal() {
            document.getElementById("modal").style.display = "none";}

        function Tdelete() {
            window.location.href = `eventedit.php?team=${document.getElementById("team-name").textContent}&action=delete`;}
    </script>
</body>
</html>

    
