<?php
    require_once "includes/dbh.inc.php";
   if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    /* PAGE IS ACCESSIBLE TO ALL
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
        header("Location: index.php");
        exit();
    }
    */
    function getImage($Folder = 'Images/eventreg/') {
        static $lastImage=-1; //static allows it to retain the value during function calls
        $images=glob($Folder.'*.{jpg,jpeg,png,gif}', GLOB_BRACE); 
        sort($images);
        $lastImage=($lastImage+1) % count($images);
        $imagePath = $images[$lastImage];
        $imageName = basename($imagePath);
        return [
            'path' => $imagePath,
            'name' => $imageName
        ];
    }
 
    //get user details
    $query='SELECT RName FROM registration_data WHERE R_id = :user_id';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id",$_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->fetch();

    //get hackathon details
    $query2='SELECT * FROM hackathon_data WHERE HDate>=CURDATE()'; 
    $stmt2=$pdo->prepare($query2);
    $stmt2->execute();
    $events=$stmt2->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hackathon Dashboard</title>
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
        const baseURL = window.location.origin;
        function showModal(h_id,is_team) {
            <?php if (isset($_SESSION['user_isadmin']) && $_SESSION['user_isadmin']==1): ?>
                const eventLink =`${baseURL}/code-battle/events/eventreg.php?H=${h_id}&T=${is_team}&L=yes`;
                document.getElementById("event-link").textContent=eventLink ;
                document.getElementById("register-button").onclick= function() {
                    window.location.href = `events/eventreg.php?H=${h_id}&T=${is_team}`;
                }
                document.getElementById("modal").style.display = "flex";
            <?php else: ?>
                window.location.href = `events/eventreg.php?H=${h_id}&T=${is_team}`;
            <?php endif; ?>
        }
            
        function hideModal() {
            document.getElementById("modal").style.display = "none";}

    </script>
</head>
<body>
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <div class=".main-container">
        <div class="header">
            <div class="header-left">
                <img src="images/codebattlelogo.png" alt="Logo" class="logo">
                <ul class="nav">
                   <!-- <li><a href="dashboard.php">Home</a></li>
                    <li><a href="events/registered_events.php">Registered Events</a></li>
                </ul>-->
            </div>
            <div class="header-right">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                    <div class="dropdown-container">
                        <button class="dropbtn"><i class="fas fa-user"></i>&#x25BC;</button>
                        <div id="profile-dropdown" class="dropdown-content">
                            <a onclick="window.location.href='logout.php';">Logout</a>
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
                <?php if (isset($_SESSION['user_id']) || isset($_SESSION['user_isadmin'])):?>
                    <h1>Welcome, <span class="username"><?php echo $user['RName']; ?></span></h1>
                <?php endif; ?>
            </div>
        </div>
        <div class="content">
            <div class="about-us-card">
                <h2>About Us</h2>
                <p>This is a coding hackathon challenge where students form teams to solve coding problems. The event encourages collaboration, problem-solving skills, and innovative thinking among students.</p>
            </div>
        </div>
    
        <div>
            <div class="eventreg-title">
                <h2>Event Registration</h2>
            </div>
            <div class="events">
                <?php foreach ($events as $event): ?>
                    <div class="events-card">
                        <?php 
                            $imageData = getImage();
                            $imagePath = $imageData['path'];
                            $imageName = $imageData['name'];

                            $query = 'UPDATE hackathon_data SET HImage=:HImage WHERE H_id=:H_id';
                            $stmt = $pdo->prepare($query);
                            $stmt->bindParam(':HImage', $imageName);
                            $stmt->bindParam(':H_id', $event['H_id']);
                            $stmt->execute();
                        ?>
                        <img src="<?php echo $imagePath ?>" alt="<?php echo $event['HName']; ?>">
                        <div class="card-details">
                            <h3><?php echo $event['HName']; ?>
                            <?php if ($event['is_team']): ?>
                                [TEAM BASED]
                            <?php else: ?>
                                [SOLO BASED]
                            <?php endif; ?></h3>
                            <ul>   
                                <li>Max Number of People: <?php echo $event['MaxP']; ?></li>
                                <li>Date: <?php echo $event['HDate']; ?></li>
                                <li>Time: <?php echo $event['HTime']; ?></li>
                                <li>Registrations Per User: <?php echo $event['reg_per_user']; ?></li>
                            </ul>
                        <a href="javascript:void(0);"  onclick="showModal('<?php echo $event['H_id'];?>','<?php echo $event['is_team'];?>')">
                        <button name="Register" class="btn-details">Register</button> </a>
                            
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="events-carousel">
            <?php foreach ($events as $index => $event): ?>
                <input type="radio" name="slider" id="s<?php echo $index + 1; ?>" <?php echo $index === 0 ? 'checked' : ''; ?> >
            <?php endforeach; ?>
            <div class="cards">
                <?php foreach ($events as $index => $event): ?>
                    <label for="s<?php echo $index + 1; ?>" id="slide<?php echo $index + 1; ?>">
                <div class="card">
                    <div class="image">
                        <img src="<?php echo getImage(); ?>" alt="<?php echo $event['HName']; ?>">
                    </div>
                <div class="infos">
                    <span class="name"><?php echo $event['HName']; ?></span>
                    <b><?php echo $event['is_team'] ? 'Team Based' : 'Solo Based'; ?></b> <br></br>
                    <span class="HDate">Date: <?php echo $event['HDate']; ?></span>
                    <span class="HTime">Time: <?php echo $event['HTime']; ?></span>
                    <a href="javascript:void(0);"  onclick="showModal('<?php echo $event['H_id'];?>','<?php echo $event['is_team'];?>')">
                    <button name="Register" class="btn-details">Register</button> </a>                   
                </div>
            </div>
                    </label>
                <?php endforeach; ?>       
            </div>
        </div>
    
        <div id="modal" class="modal-background">
            <div class="modal-content">
                <p class="modal-text">SHARABLE HACKATHON LINK: <br></br> <span id="event-link"></span></p>
                <div class="modal-button-container">
                    <button class="modal-button" onclick="hideModal()">Cancel</button>
                    <button class="modal-button" id="register-button">Register</button>
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>Code Battle &copy; 2024. All rights reserved. Made with ❤️ in U.A.E</p>
        </footer>
    </div>

</body>
</html>
