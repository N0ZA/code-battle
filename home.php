<?php
// Mock user data
$users = [
    ["name" => "John Doe", "role" => "Math Teacher"],
    ["name" => "Jane Smith", "role" => "Science Teacher"],
    ["name" => "Alice Johnson", "role" => "Computer Science Teacher"]
];

// For simplicity, let's assume the first user is logged in
$logged_in_user = $users[2];

// Mock event data
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
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hackathon Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min">
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
    </script>
</head>
<body>
    <div class=".main-container">

        <div class="header">
            <div class="header-left">
                <img src="images/codebattlelogo.png" alt="Logo" class="logo">
                <ul class="nav">
                    <li><a href="home.php">Home</a></li>
                    <li><a href="registeredevents.php">Registered Events</a></li>
                    <li><a href="edit-teams.php">Edit Teams</a></li>
                </ul>
            </div>
            <div class="header-right">
                <img src="images/profile-icon.png" alt="Profile" class="profile-icon" onclick="toggleDropdown()">
                <div id="profile-dropdown" class="dropdown-content">
                    <a href="#">Logout</a>
                </div>
            </div>
        </div>
        <div class="welcome-container">
            <div class="welcome">
                <h1>Welcome, <span class="username"><?php echo $logged_in_user['name']; ?></span></h1>
                <p>Role: <?php echo $logged_in_user['role']; ?></p>
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
                        <img src="<?php echo $event['image']; ?>" alt="<?php echo $event['name']; ?>">
                        <div class="card-details">
                            <h3><?php echo $event['name']; ?></h3>
                            <ul>
                                <li>Category: <?php echo $event['category']; ?></li>
                                <li>Date: <?php echo $event['date']; ?></li>
                                <li>Time: <?php echo $event['time']; ?></li>
                                <li>Venue: <?php echo $event['venue']; ?></li>
                            </ul>
                            <button>Register</button>
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