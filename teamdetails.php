<?php
// Mock user data
$users = [
    ["name" => "John Doe", "role" => "Math Teacher"],
    ["name" => "Jane Smith", "role" => "Science Teacher"],
    ["name" => "Alice Johnson", "role" => "Computer Science Teacher"]
];


$logged_in_user = $users[2];
// Mock team data
$teams = [
    [
        "team_name" => "Team Alpha",
        "hackathon_name" => "Hackathon 2024",
        "members" => ["Alice Johnson", "Bob Smith", "Charlie Davis"],
        "image" => "images/teams/team1.png"
    ],
    [
        "team_name" => "Team Beta",
        "hackathon_name" => "CodeFest 2024",
        "members" => ["David Lee", "Eva Green", "Frank White"],
        "image" => "images/teams/team2.png"
    ],
    [
        "team_name" => "Team Gamma",
        "hackathon_name" => "DevHack 2024",
        "members" => ["Grace Kim", "Hank Brown", "Ivy Wilson"],
        "image" => "images/teams/team3.png"
    ]
];

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
            <h1><span class="username"><?php echo $logged_in_user['name']; ?></span></h1>
            <p>Role: <?php echo $logged_in_user['role']; ?></p>
        </div>
    </div>
    <div class="teams-title">
        <h2>Registered Teams</h2>
    </div>
        <div class="team-card-container">
            <?php foreach ($teams as $team): ?>
                <div class="team-card" id="<?php echo $team['team_name']; ?>" onclick="CardClick(this)">
                    <div class="card-inner">
                        <div class="card-front">
                            <div id="team-image">
                            <img src="<?php echo $team['image']; ?>" alt="<?php echo $team['team_name']; ?>" class="team-img">
                            </div>
                            <div class="card-text">
                                <h3><strong><?php echo $team['team_name']; ?></strong></h3>
                            </div>
                        </div>
                        <div class="card-back">
                            <div class="card-members">
                                <p>Members:</p>
                                <ul class="member-list">
                                    <?php foreach ($team['members'] as $member): ?>
                                        <li><?php echo $member; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="card-actions">
                                <a href="add_member.php?team=<?php echo $team['team_name']; ?>" class="icon-link"><i class="fas fa-plus"></i></a>
                                <a href="edit_team.php?team=<?php echo $team['team_name']; ?>" class="icon-link"><i class="fas fa-edit"></i></a>
                                <a href="delete_team.php?team=<?php echo $team['team_name']; ?>" class="icon-link"><i class="fas fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
</div>

</body>
</html>

    
