<?php
    require_once "includes/dbh.inc.php";
    require_once 'includes/config_session.inc.php';
    require_once 'eventreg.php';

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


/* Mock event data
$events = [
    [
        "image" => "images/eventreg/CB24Sharjah.jpg",
        "name" => "Code Battle '24 <br>Sharjah and N.Emirates",
        "category" => "Jr Cadet, Jr Captain and Jr Colonel",
        "date" => "July 20, 2024",
        "time" => "10:00 AM",
        "venue" => "Main Auditorium"
    ],
    [
        "image" => "images/eventreg/CB24AD.jpg",
        "name" => "Code Battle '24 Abu Dhabi Chapter",
        "category" => "Jr Cadet, Jr Captain and Jr Colonel",
        "date" => "August 12, 2024",
        "time" => "2:00 PM",
        "venue" => "Lab 3"
    ],
    [
        "image" => "images/eventreg/CB24NF.jpg",
        "name" => "Code Battle '24 National Finals",
        "category" => "Jr Cadet, Jr Captain and Jr Colonel",
        "date" => "September 10, 2024",
        "time" => "9:00 AM",
        "venue" => "Dubai Digital Park, Silicon Oasis"
    ]
];*/

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
                    <li><a href="registeredevents.php">Registered Events</a></li>
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
                        <?php 
                            $_SESSION['H_id']=$event['H_id'];
                        ?>
                        <img src="<?php echo getImage(); ?>" alt="<?php echo $event['HName']; ?>">
                        <div class="card-details">
                        <?php if ($event['is_team']): ?>
                            <b>TEAM BASED </b>
                        <?php endif; ?>
                            <h3><?php echo $event['HName']; ?></h3>
                            <ul>    
                                <?php if ($event['is_team']): ?>
                                    <li>Category: Jr Cadet= <?php echo $event['Jr_Cadet']; ?></li>
                                    <li>Category: Jr Captain= <?php echo $event['Jr_Captain']; ?></li>
                                    <li>Category: Jr Colonel <?php echo $event['Jr_Colonel']; ?></li>
                                    <li>Max Number of People: <?php echo $event['MaxP']; ?></li>
                                <?php else: ?>
                                    <li>Category: 
                                        <?php 
                                            if ($event['Jr_Cadet']) echo 'Jr Cadet';
                                            elseif ($event['Jr_Captain']) echo 'Jr Captain';
                                            elseif ($event['Jr_Colonel']) echo 'Jr Colonel';
                
                                        ?>
                                    </li
                                <?php endif; ?>
                                <li>Date: <?php echo $event['HDate']; ?></li>
                                <li>Time: <?php echo $event['HTime']; ?></li>
                            </ul>
                            <form action="eventreg.php" method="POST">
                                <input type="hidden" name="is_team" value="<?php echo $event['is_team']; ?>">
                            <button type="submit">Register</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
    
            </div>
        </div>
        <div class="events-carousel">
            <input type="radio" name="slider" id="s1" checked>
            <input type="radio" name="slider" id="s2">
            <input type="radio" name="slider" id="s3">
            <input type="radio" name="slider" id="s4">
            <input type="radio" name="slider" id="s5">
    
            <div class="cards">
                <label for="s1" id="slide1">
                    <div class="card">
                        <div class="image">
                            <img src="images/eventreg/CB24Sharjah.jpg" alt="Sharjah Chapter">
                        </div>
    
                        <div class="infos">
                            <span class="name">Code Battle '24 Sharjah and N.Emirates</span>
                            <span class="det">Date: 24th July 2024</span>
                            <span class="det">Time: 10:00 AM - 12:00 PM</span>
                            <span class="det">Venue: Sharjah University</span>
    
                            <a href="/register" class="btn-details">Register</a>
                        </div>
                    </div>
                </label>
                <label for="s2" id="slide2">
                    <div class="card">
                        <div class="image">
                            <img src="images/eventreg/CB24AD.jpg" alt="Abu Dhabi Chapter">
                        </div>
    
                        <div class="infos">
                            <span class="name">Code Battle '24 Abi Dhabi</span>
                            <span class="det">Date: 15th August 2024</span>
                            <span class="det">Time: 10:00 AM - 12:00 PM</span>
                            <span class="det">Venue: Khaifa University</span>
    
                            <a href="/register" class="btn-details">Register</a>
                        </div>
                    </div>
                </label>
                <label for="s3" id="slide3">
                    <div class="card">
                        <div class="image">
                            <img src="/images/eventreg/CB24Dubai.jpg" alt="Dubai Chapter">
                        </div>
    
                        <div class="infos">
                            <span class="name">Code Battle '24 Dubai Chapter</span>
                            <span class="det">Date: 25th September 2024</span>
                            <span class="det">Time: 10:00 AM - 12:00 PM</span>
                            <span class="det">Venue: Internet Park,Silicon Oasis</span>
    
                            <a href="/register" class="btn-details">Register</a>
                        </div>
                    </div>
                </label>
                <label for="s4" id="slide4">
                    <div class="card">
                        <div class="image">
                            <img src="/images/eventreg/CB24NF.jpg" alt="National Finals">
                        </div>
    
                        <div class="infos">
                            <span class="name">Code Battle '24 Final Chapter</span>
                            <span class="det">Date: 02 th November 2024</span>
                            <span class="det">Time: 10:00 AM - 12:00 PM</span>
                            <span class="det">Venue: Dubai Digital Park, Silicon Oasis</span>
    
                            <a href="/register" class="btn-details">Register</a>
                        </div>
                    </div>
                </label>
                <label for="s5" id="slide5">
                    <div class="card">
                        <div class="image">
                            <img src="/images/eventreg/CB24NF.jpg" alt="National Finals">
                        </div>
    
                        <div class="infos">
                            <span class="name">Code Battle '24 New Chapter</span>
                            <span class="det">Date: 15 December 2024</span>
                            <span class="det">Time: 10:00 AM - 12:00 PM</span>
                            <span class="det">Venue: Dubai Digital Park, Silicon Oasis</span>
    
                            <a href="/register" class="btn-details">Register</a>
                        </div>
                    </div>
                </label>
            </div>
        </div>
    
        
    
        <footer class="footer">
            <p>Code Battle &copy; 2024. All rights reserved. Made with ❤️ in U.A.E</p>
        </footer>
    </div>

</body>
</html>
