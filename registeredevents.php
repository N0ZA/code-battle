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
        "image" => "images/eventreg/CB24NF.jpg",
        "name" => "Code Battle '24 National Finals",
        "category" => "Jr Cadet, Jr Captain and Jr Colonel",
        "type" => "CodeBattle",
        "date" => "September 10, 2024",
        "time" => "9:00 AM",
        "venue" => "Dubai Digital Park, Silicon Oasis"
    ],
    [
        "image" => "images/eventreg/CB24Sharjah.jpg",
        "name" => "Code Battle '24 <br>Sharjah and N.Emirates",
        "category" => "Jr Cadet, Jr Captain and Jr Colonel",
        "type" => "CodeBattle",
        "date" => "July 20, 2024",
        "time" => "10:00 AM",
        "venue" => "Main Auditorium"
    ],
    [
        "image" => "images/eventreg/CB24AD.jpg",
        "name" => "Code Battle '24 Abu Dhabi Chapter",
        "category" => "Jr Cadet, Jr Captain and Jr Colonel",
        "type" => "CodeNova",
        "date" => "August 12, 2024",
        "time" => "2:00 PM",
        "venue" => "Lab 3"
    ]
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
    <div class="main-container">

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
                    <img src="images/qr.png" alt="QR Code" class="qr-code">
                    <?php if ($event['type'] == "CodeBattle"): ?>
                        <button>Add Teams</button>
                        <button>Edit Teams</button>
                        <button>Delete Teams</button>
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
