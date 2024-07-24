<?php
    require_once "includes/dbh.inc.php";
    require_once 'eventreg.php';
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
        header("Location: index.php");
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

    //get hackathon details
    $query2='SELECT * FROM hackathon_data'; 
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
                    <li><a href="dashboard.php">Home</a></li>
                    <li><a href="registered_events.php">Registered Events</a></li>
                </ul>
            </div>
            <div class="header-right">
                <ul class="nav">
                    <li><a href="logout.php">Logout</a></li>
                </ul>
                <!--<img src="images/profile-icon.png" alt="Profile" class="profile-icon" onclick="toggleDropdown()">
                <div id="profile-dropdown" class="dropdown-content">
                    <a href="#">Logout</a> 
                </div>-->
            </div>
        </div>
        <div class="welcome-container">
            <div class="welcome">
                <h1>Welcome, <span class="username"><?php echo strtoupper($user['RName']); ?></span></h1> 
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
                        <img src="<?php echo getImage(); ?>" alt="<?php echo $event['HName']; ?>">
                        <div class="card-details">
                        <?php if ($event['is_team']): ?>
                            <b>TEAM BASED </b>
                        <?php endif; ?>
                            <h3><?php echo $event['HName']; ?></h3>
                            <ul>   
                                <li>Category</li>
                                <li>Jr Cadet: <?php echo $event['Jr_Cadet']; ?></li>
                                <li>Jr Captain:  <?php echo $event['Jr_Captain']; ?></li>
                                <li>Jr Colonel: <?php echo $event['Jr_Colonel']; ?></li>
                                <li>Max Number of People: <?php echo $event['MaxP']; ?></li>
                                <li>Date: <?php echo $event['HDate']; ?></li>
                                <li>Time: <?php echo $event['HTime']; ?></li>
                            </ul>
                            <form action="eventreg.php" method="POST">
                                <input type="hidden" name="H_id" value="<?php echo $event['H_id']; ?>">
                                <?php
                                    $C_id = ($event['Jr_Cadet']) ? 1 : (($event['Jr_Captain']) ? 2 : (($event['Jr_Colonel']) ? 3 : ''));
                                ?>
                                <input type="hidden" name="C_id" value="<?php echo $C_id; ?>">
                                <input type="hidden" name="is_team" value="<?php echo $event['is_team']; ?>">
                                <button type="submit">Register</button>
                            </form>
                            
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
                    <a href="/register" class="btn-details">Register</a>
                </div>
            </div>
                    </label>
                <?php endforeach; ?>       
            </div>
        </div>
    
        <footer class="footer">
            <p>Code Battle &copy; 2024. All rights reserved. Made with ❤️ in U.A.E</p>
        </footer>
    </div>

</body>
</html>
