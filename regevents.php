<?php
    require_once "includes/dbh.inc.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
        header("Location: ../index.php");
        exit();
    }

    function getImage($Folder = 'images/eventreg/') {
        $images = glob($Folder.'*.{jpg,jpeg,png,gif}', GLOB_BRACE); //to get all files from image folder tht match the extensions
        $randomImage = $images[array_rand($images)];
        return $randomImage;
    }
 
    //get user details
    $query='SELECT RName FROM registration_data WHERE R_id = :user_id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id",$_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->fetch();

    $query3 = 'SELECT hackathon_data.*, team_data.TName AS TeamName FROM hackathon_data 
                JOIN team_data ON hackathon_data.H_id = team_data.H_id 
                WHERE team_data.Tuser_id = :user_id';
    $stmt3 = $pdo->prepare($query3);
    $stmt3->bindParam(":user_id", $_SESSION['user_id']);
    $stmt3->execute();
    $Tevents = $stmt3->fetchAll();
    
    $query4 = 'SELECT hackathon_data.*, solo_data.PName AS SoloName FROM hackathon_data 
                JOIN solo_data ON hackathon_data.H_id = solo_data.H_id 
                WHERE solo_data.Puser_id = :user_id AND solo_data.T_id IS NULL';
    $stmt4 = $pdo->prepare($query4);
    $stmt4->bindParam(":user_id", $_SESSION['user_id']);
    $stmt4->execute();
    $Sevents = $stmt4->fetchAll();
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <script>
        function toggleDropdown() {
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
        }
        window.addEventListener('load', function(){
            const preloader = document.querySelector('.preloader');
            preloader.style.display = 'none';
        });
    </script>
</head>
<body>
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <div class="main-container">

    <div class="header">
        <div class="header-left">
            <img src="images/codebattlelogo.png" alt="Logo" class="logo">
            <ul class="nav">
                <li><a href="home.php">Home</a></li>
                <li><a href="registeredevents.php">Registered Events</a></li>
            </ul>
        </div>
        <div class="header-right">
        <ul class="nav">
                <li><a href="signin.php">Logout</a></li>
            </ul>
            <!--<img src="images/profile-icon.png" alt="Profile" class="profile-icon" onclick="toggleDropdown()">
            <div id="profile-dropdown" class="dropdown-content">
                <a href="#">Logout</a> 
            </div>-->
        </div>
    </div>
    <div class="welcome-container">
        <div class="welcome">
            <h1>Welcome, <span class="username"><?php echo $logged_in_user['name']; ?></span></h1>
            <p>Role: <?php echo $logged_in_user['role']; ?></p>
        </div>
    </div>

    
    <div>
        <div class="eventreg-title">
            <h2>Registered Events</h2>
        </div>
    <div class="events">
        <?php foreach ($events as $event): ?>
            <div class="events-card">
                <img src="<?php echo $event['image']; ?>" alt="<?php echo $event['name']; ?>">
                <div class="card-details">
                    <h3><?php echo $event['name']; ?></h3>
                    <!--<img src="images/qr.png" alt="QR Code" class="qr-code">-->
                    <?php if ($event['type'] == "CodeBattle"): ?>
                        <button>Add Teams</button>
                        <button>Edit Teams</button>
                        <!--<button>Delete Teams</button>-->
                    <?php elseif ($event['type'] == "CodeNova"): ?>
                        <button>Add Member</button>
                        <button>Discard Member</button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    </div>
</body>
</html>
