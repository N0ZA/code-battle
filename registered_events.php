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
    $registered_team_events = $stmt3->fetchAll();
    
    $query4 = 'SELECT hackathon_data.*, solo_data.PName AS SoloName FROM hackathon_data 
                JOIN solo_data ON hackathon_data.H_id = solo_data.H_id 
                WHERE solo_data.Puser_id = :user_id';
    $stmt4 = $pdo->prepare($query4);
    $stmt4->bindParam(":user_id", $_SESSION['user_id']);
    $stmt4->execute();
    $registered_solo_events = $stmt4->fetchAll();
    ?>

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
        <div>
            <div class="eventreg-title">
                <h2>Registered Events</h2>
            </div>
            <div class="events">
                <div class="registered-events">
                    <?php if (!empty($registered_team_events)): ?>
                        <?php foreach ($registered_team_events as $event): ?>
                            <div class="events-card">
                                <img src="<?php echo getImage(); ?>" alt="<?php echo $event['HName']; ?>">
                                <div class="card-details">
                                    <h3><?php echo $event['HName']; ?></h3>
                                </div>
                                <button>Add Teams</button>
                                <button>Edit Teams</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if (!empty($registered_solo_events)): ?>
                        <?php foreach ($registered_solo_events as $event): ?>
                            <div class="events-card">
                                <img src="<?php echo getImage(); ?>" alt="<?php echo $event['HName']; ?>">
                                <div class="card-details">
                                    <h3><?php echo $event['HName']; ?></h3>
                                </div>
                                <button>Add Member</button>
                                <button>Discard Member</button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>You have not registered for any events yet.</p>
                    <?php endif; ?>
                </div>

        </div>
    </body>
    </html>
    