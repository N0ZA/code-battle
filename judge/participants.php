<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../includes/dbh.inc.php';
require_once '../includes/config_session.inc.php';

$_SESSION['CName']=$_GET['categoryname'];
$query1 = "SELECT C_id from category where CName=:CName;";
$stmt1 = $pdo->prepare($query1);
$stmt1->bindParam(":CName",$_SESSION['CName']);
$stmt1->execute();
$val=$stmt1->fetchColumn();


if ($_SESSION['is_team']==1){

    $query3 = "SELECT td.T_id, td.TName, IFNULL(SUM(ts.Score), 0) AS score
    FROM team_data td
    LEFT JOIN team_scores ts ON td.T_id = ts.T_id AND ts.J_id = :J_id
    WHERE td.C_id = :C_id AND td.H_id = :H_id GROUP BY td.T_id, td.TName HAVING score=0;";

}
else{
   
    $query3 = "SELECT sd.P_id, sd.PName, IFNULL(SUM(ss.Score), 0) AS score
    FROM solo_data sd
    LEFT JOIN solo_scores ss ON sd.P_id = ss.P_id AND ss.J_id = :J_id
    WHERE sd.C_id = :C_id AND sd.H_id = :H_id GROUP BY sd.P_id, sd.PName HAVING score=0;";

}

$stmt3 = $pdo->prepare($query3);
$stmt3->bindParam(":H_id", $_SESSION['H_id']);
// echo $_SESSION['H_id'];
$stmt3->bindParam(":J_id", $_SESSION['J_id']);
// echo $_SESSION['J_id'];
$stmt3->bindParam(":C_id",$val);
// echo $val;
$stmt3->execute();

//name id and score 
$result3=$stmt3->fetchAll(PDO::FETCH_ASSOC);

?>
    
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Code Battle - Team Score</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #E3E3E3;
            background-image: url(../images/grids.jpeg);
            background-size: cover;
            color: black;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .card {
            background-color: transparent;
            width: 300px;
            height: 500px;
            perspective: 1000px;
            display: flex;
            margin: auto;
            margin-bottom: 50px;
        }

        .card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
            transition: transform 0.6s;
            transform-style: preserve-3d;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }

        .card-container{
            display: flex;
            justify-content: space-around; /* Adjust alignment */
            flex-wrap: wrap; /* Allow cards to wrap to next line */
            max-width: 1000px; /* Limit container width */
            margin: 0 auto; /* Center container */
            padding: 20px; /* Add some spacing */
        }
        .card:hover .card-inner {
            transform: rotateY(180deg);
        }

        .card h1 {
            font-size:90px;
        }

        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 18px;
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
        }

        .card-front {
            background-color: white;
            color: black;
            grid-template-columns: 400px;
            grid-template-rows: 290px 210px;
            grid-template-areas: "image" "text";
        }

        .card-back {
            background-color: #F73634;
            color: white;
            transform: rotateY(180deg);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-text {
            grid-area: text;
            margin: 25px;
        }
            
        .card-text p {
            font-size:15px;
            font-weight: 300;
        }
        .card-text h2 {
            margin-top:0px;
            font-size:28px;
        }
        .card-text h3 {
            margin-top:70px;

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

        .button-container {
            text-align: center;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background-color: #F73634;
            padding: 15px;
        }

        button:hover {          
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
            background-color: black;
            color: #ffffff; 
            padding: 5px;
            text-align: center;
            position: fixed; /* Set position to fixed */
            bottom: 0; /* Position at the bottom */
            width: 100%; 
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

    <script>
        function CardClick(card) {
            var id=card.getAttribute('id');
            // console.log(T_id);
            window.location.href = 'grading.php?id=' + id;
        }

    </script>
</head>
<script>
  window.addEventListener('load', function(){
    const preloader = document.querySelector('.preloader');
    preloader.style.display = 'none';
  });
</script>
<body>
<div class="preloader">
  <div class="loader"></div>
</div>
<div class="button-container">
    <button id = "home-container" name="view-scoreboard" onClick="window.location.href='judge.php';">Home</button>
    <div id="scoreboard-dropdown-container" class="scoreboard-dropdown-container">
        <button id="scoreboard" name="view-scoreboard">Scoreboard &#x25BC;</button>
        <div class="score-dropdown">
            <a onclick="window.location.href='myScores.php';">My Scoreboard</a>
            <a onclick="window.location.href='otherjudges.php';">Judges Scoreboard</a>
            <a onclick="window.location.href='Result.php';">Team Scoreboard</a>
        </div>
    </div>
    <button name="update" onClick="window.location.href='updatescores.php';">Update Score</button>
    <div class="scoreboard-dropdown-container" id ="profile-container">
      <button class="dropbtn"><i class="fas fa-user"></i>&#x25BC;</button>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
      <div id ="profile-dropdown" class="score-dropdown">
        <a onclick="window.location.href='../logout.php';">Logout</a>
      </div>
    </div>

  </div>

    <h1 style="text-align:center;margin-top: 90px;"><?php echo $_SESSION['CName'].'s'?></h1>  
    <?php if(!empty($result3)) { ?> 
        <h1 style="text-align:center;">Click to grade. </h1>  
        <div class="card-container">
            <?php foreach($result3 as $row) { 
                // echo $row['T_id'];?>
                <!-- setting T_id as the id of each card -->
                <?php if($_SESSION['is_team']==1){?>
                <div class="card" id="<?php echo $row['T_id']; ?>" onclick="CardClick(this)">
                    <div class="card-inner">
                        <div class="card-front">
                            <div id="cadet-image">
                                <img src="https://img.freepik.com/premium-vector/red-circuit-board-wallpaper-digital-technology-background_636138-735.jpg" alt="Italian Trulli" style="width: 300px; height:290px; border-top-right-radius: 16px; border-top-left-radius: 16px;">
                            </div>
                            <div class="card-text">
                                <h2><?php echo $row['T_id'] ?></h2>
                                <h2><?php echo $row['TName'] ?></h2>
                            </div>
                        </div>
                        <div class="card-back">
                            <p>SCORE</p>
                            <h1><?php echo $row['score'] ?></h1>
                        </div>
                    </div>
                </div>
                <?php }else{?>
                    <div class="card" id="<?php echo $row['P_id']; ?>" onclick="CardClick(this)">
                    <div class="card-inner">
                        <div class="card-front">
                            <div id="cadet-image">
                                <img src="https://img.freepik.com/premium-vector/red-circuit-board-wallpaper-digital-technology-background_636138-735.jpg" alt="Italian Trulli" style="width: 300px; height:290px; border-top-right-radius: 16px; border-top-left-radius: 16px;">
                            </div>
                            <div class="card-text">
                                <h2><?php echo $row['P_id'] ?></h2>
                                <h2><?php echo $row['PName'] ?></h2>
                            </div>
                        </div>
                        <div class="card-back">
                            <p>SCORE</p>
                            <h1><?php echo $row['score'] ?></h1>
                        </div>
                    </div>
                </div>
                <?php }?>
            <?php } ?>
        </div>
    <?php } else { ?>
        <h2 style="text-align: center;">Everyone under this category has been graded.</h2>
    <?php } ?>
    <footer>
        <p>Code Battle &copy; 2024. All rights reserved. Made with ❤️ in U.A.E</p>
    </footer>
</body>
</html>
