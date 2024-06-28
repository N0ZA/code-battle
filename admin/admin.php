
<?php
    require_once '../includes/config_session.inc.php';
if ((isset($_SESSION['user_isadmin'])) &&  $_SESSION['user_isadmin']==1) {

require_once "../admin/admin_functions.php";


?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Battle - Admin</title>
    <style>
        header{
            display: inline-block;
            width: 100%;
        }
        h1{
            width: 50%;

        }
        .logout{
            text-align: right;
            width: 20%;
            margin-left: auto;
        }

        body{
            font-family: 'Arial', sans-serif;
            color: black;
            margin: 0;
            padding: 0;
            background-color: #E3E3E3;
            background-image: url(../Images/grids.jpeg);
            background-size: cover;
            min-height: 100vh;
        }

        table {
            text-align: center;
            width: 50%;
            border-collapse: collapse;
            background-color: #F73634;
            margin-left: auto;
            margin-right: auto;
            border-radius: 18px;
        }

        th{
            border-radius: 18px;
            color: white;
            background-color: #F73634;
            font-size: medium;
            padding: 8px;
        } 
        
        
        td {
            background-color: white;
            color: black;
            font-size: medium;
            padding: 8px;
            
        }

        h2{
            text-align: center;
        }

        .button-container {
            text-align: center;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background-color: #F73634;
            padding: 15px;
        }

        .button-wrapper {
            margin: 1rem;
        }

        button {
            background-color: #F73634;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: large;
            padding: 5px 30px; 
            margin-left: 1em;
            border-radius: 18px;
            font-weight: bold;
        }

        button:hover{
            text-decoration: underline;
        }

        .score-dropdown {
      margin-left: 40px;
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }

    .score-dropdown a {
        font-family: 'Arial', sans-serif;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    .score-dropdown a:hover {
        background-color: #ddd;
    }
    .scoreboard-dropdown-container:hover .score-dropdown {
        display: block;
    }

    #profile-dropdown{
      margin-left: 10px;
    }

        footer {
            background-color: #000000;
            color: #ffffff; 
            padding: 5px;
            text-align: center;
            position: sticky;
            top: 100%;
        }
       
        .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #272727;
        color:#F73634;
        font-size: x-large;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .loader {
        border: 8px solid #0000007c;
        border-top: 8px solid #F73634;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 2s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    </style>
</head>

<body>
<div class="preloader">
  <div class="loader"></div>
</div>
    <div class="button-container">
        <button type="submit" onClick="window.location.href='admin.php';">Home</button>
        <button type="submit" onClick="window.location.href='HDetail.php';">View Hackathon</button>
        <button type="submit" name="create_hackathon" onClick="window.location.href='create.php';">Create Hackathon</button>
        <div class="scoreboard-dropdown-container" id ="profile-container">
        <button class="dropbtn"><i class="fas fa-user"></i>&#x25BC;</button>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <div id ="profile-dropdown" class="score-dropdown">
            <a onclick="window.location.href='../logout.php';">Logout</a>
        </div>
        </div>
    </div>
    <?php
        echo '<h1>Welcome <font color="#F73634">'.$_SESSION["user_username"].',</font></h1>';
    ?>
    
    <h2>Hackathon Details</h2>
    <div id="table">
        <script>
            fetch('admin_n.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('table').innerHTML = data;
            })
            .catch(error => {
                console.error('Error fetching table', error);
            });

               
        </script>
    </div>

    <script>

        function load(){
            const preloader = document.querySelector('.preloader');
            preloader.style.display = 'none';
        }

        window.addEventListener('load', load);
        
</script>
          
    
</body>
<footer>
    <p>Code Battle &copy; 2024. All rights reserved. Made with ❤️ in U.A.E</p>
</footer>
</html>
<?php }
// else if ((isset($_SESSION['user_isadmin'])) &&  $_SESSION['user_isadmin']==0) {
//     header("Location: ../judge/judge.php");
//     die();
// }
else{
    header("Location: ../index.php");
    die();
} ?>