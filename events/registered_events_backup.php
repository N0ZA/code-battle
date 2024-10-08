<?php
    require_once "../includes/dbh.inc.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
        header("Location: ../index.php");
        exit();
    }
    unset($_SESSION['new_TM']);
    unset($_SESSION['TName']);
    unset($_SESSION['H_id']);
    unset($_SESSION['is_team']);
 
    function getImage($eventImage) {
        $folder = '../Images/eventreg/';
        $imagePath = $folder . $eventImage;
        return $imagePath;
    }
    //get user details
    $query='SELECT RName FROM registration_data WHERE R_id = :user_id';
    $stmt=$pdo->prepare($query);
    $stmt->bindParam(":user_id",$_SESSION['user_id']);
    $stmt->execute();
    $user=$stmt->fetch();

    $query1='SELECT * FROM event_reg WHERE user_id = :user_id';
    $stmt1=$pdo->prepare($query1);
    $stmt1->bindParam(":user_id",$_SESSION['user_id']);
    $stmt1->execute();
    $events=$stmt1->fetchAll();

?>    


    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registered Events</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
        <link rel="stylesheet" href="../css/styles.css">
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
    <style>
        .welcome-container {
            margin-top: -80px; 
        }

    </style>
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
        <div>
            <div class="eventreg-title">
                <h2>Registered Events</h2>
            </div>
        <div class="events">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $event): ?>
                    <?php
                        $query2 ='SELECT * FROM hackathon_data WHERE H_id = :H_id';
                        $stmt2 = $pdo->prepare($query2);
                        $stmt2->bindParam(':H_id', $event['H_id']);
                        $stmt2->execute();
                        $eventDetails=$stmt2->fetch();
                        $is_team=$eventDetails['is_team']
                     ?>

                    <div class="events-card">
                        <img src="<?php echo getImage($eventDetails['HImage']); ?>" alt="<?php echo $eventDetails['HName'];?>">
                        <div class="card-details">
                            <h3><u> <?php echo strtoupper($eventDetails['HName']); ?> </u> <br></br>
                            <?php if ($is_team): ?> Team Based
                            <?php else: ?>  Solo Based
                            <?php endif; ?></h3>
                            <?php // echo  $eventDetails['H_id'] ?>
                            <form action="eventreg.php" method="POST">
                                <input type="hidden" name="H_id" value="<?php echo $eventDetails['H_id']; ?>">
                                <input type="hidden" name="is_team" value="<?php echo $eventDetails['is_team']; ?>">
                                <?php if ($is_team): ?> 
                                    <button type="submit" name="Add_Team">Add Team</button>
                                    <button type="submit" name="Edit_Teams">View Teams</button>
                                <?php else: ?> 
                                    <button type="submit" name="Add_Member">Add Member</button>
                                    <button type="submit" name="Edit_Members">View Members</button>
                                <?php endif; ?>
                            </form>
                           
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>You have not registered for any events yet.</p>
            <?php endif; ?>
        </div>
        </div>
    </body>
    </html>
    
                