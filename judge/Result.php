<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once '../includes/dbh.inc.php';
require_once '../includes/config_session.inc.php';

if ($_SESSION['is_team']==1){
    $query1 = "SELECT T_id, TName, ROUND(AVG(J_score)) as Total_Score
           FROM (SELECT T_id, TName, SUM(Score) as J_score 
                 FROM team_scores 
                 WHERE H_id=:H_id
                 GROUP BY T_id, J_id) as subquery 
           GROUP BY T_id
           ORDER BY Total_Score DESC";
}else{
    $query1 = "SELECT P_id, PName, ROUND(AVG(J_score)) as Total_Score
           FROM (SELECT P_id, PName, SUM(Score) as J_score 
                 FROM solo_scores 
                 WHERE H_id=:H_id
                 GROUP BY P_id, J_id) as subquery 
           GROUP BY P_id
           ORDER BY Total_Score DESC";

}
    $stmt1=$pdo->prepare($query1);
    $stmt1->bindParam(":H_id",$_SESSION['H_id']);
    $stmt1->execute();
    $participants=$stmt1->fetchAll();

    $q5="SELECT * FROM criteria_data WHERE H_id=:H_id";
    $s5=$pdo->prepare($q5);
    $s5->bindParam(":H_id",$_SESSION['H_id']);
    $s5->execute();
    //found
    $criterias=$s5->fetchAll(PDO::FETCH_ASSOC);
    // var_dump($criterias);
// Modified by harsh

if ($_SESSION['is_team']==1){
    $q7="Select ROUND(AVG(Score)) from team_scores where H_id=:H_id and T_id=:T_id and CR_id In (SELECT CR_id FROM criteria_data WHERE CRName =:CRName)";
}else{
    $q7="Select ROUND(AVG(Score)) from solo_scores where H_id=:H_id and P_id=:P_id and CR_id In (SELECT CR_id FROM criteria_data WHERE CRName =:CRName)";
}
$s7=$pdo->prepare($q7);
$s7->bindParam(":H_id",$_SESSION['H_id']);
    
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Code Battle - Scoreboard</title>
    <style>
        img{
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        body {
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
            background-color: #E3E3E3;
            background-image: url(../images/grids.jpeg);
            background-size: cover;
            color: #F73634;
            margin: 0;
            padding: 0;
        }

        image{
            align-content: center;
        }

        table {
            text-align: center;
            width: 50%;
            border-collapse: collapse;
            background-color: #F73634;
            margin-left: auto;
            margin-right: auto;
            border-radius: 18px;
            margin-bottom: 4rem;
        }

        th{
            border-radius: 18px;
            color: white;
            background-color: #F73634;
            font-size: medium;
            padding: 8px;
        }

        td{
            background-color: white;
            color: black;
            font-size: medium;
            padding: 8px;
        }

        footer {
            background-color: black;
            color: #ffffff; 
            padding: 8px;
            text-align: center;
            position: sticky;
            top: 100%;
        }

        h1{
            text-align: center;
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

    <?php if ($_SESSION['is_team']==1){ ?>
        <?php if($participants){?>
            <h1><font color = "black">Final </font>Scoreboard</h1>
            <table>
            <tr>
                <th>Team ID</th>
                <th>Team Name</th>
                <?php foreach($criterias as $criteria){?> 
                    <th><?php echo $criteria['CRName']?></th>
                    <?php }?>
                    <th>Scores</th>
                </tr>
                
                <?php foreach($participants as $team){?>
                        <tr>
                            <td><?php echo $team['T_id'] ?></td>
                            <td><?php echo $team['TName'] ?></td>
                                <?php $s7->bindParam(":T_id",$team['T_id']);
                                foreach($criterias as $criteria){
                                    $s7->bindParam(":CRName",$criteria['CRName']);
                                    $s7->execute();
                                    //criteria_sum found
                                    $criteria_sum=$s7->fetchColumn();?>
                                    <td><?php echo $criteria_sum;?></td>
                                <?php }?>
                                <td><?php echo $team['Total_Score'] ?></td>
                                
                        </tr>
                        <?php  }   ?>
                    </table>
        <?php }else{ ?> 
            <?php echo "<h1><font color=\"black\">No teams graded</font></h1>"; ?></td>
        <?php }
    }else{?>
        <?php if($participants){?>
            <h1><font color = "black">Final </font>Scoreboard</h1>
            <table>
            <tr>
                <th>Player ID</th>
                <th>Player Name</th>
                <?php foreach($criterias as $criteria){?> 
                    <th><?php echo $criteria['CRName']?></th>
                    <?php }?>
                    <th>Scores</th>
                </tr>
                
                <?php foreach($participants as $player){?>
                        <tr>
                            <td><?php echo $player['P_id'] ?></td>
                            <td><?php echo $player['PName'] ?></td>
                                <?php $s7->bindParam(":P_id",$player['P_id']);
                                foreach($criterias as $criteria){
                                    $s7->bindParam(":CRName",$criteria['CRName']);
                                    $s7->execute();
                                    //criteria_sum found
                                    $criteria_sum=$s7->fetchColumn();?>
                                    <td><?php echo $criteria_sum;?></td>
                                <?php }?>
                                <td><?php echo $player['Total_Score'] ?></td>
                                
                        </tr>
                        <?php  }   ?>
            </table>
        <?php }else{ ?>
            <?php echo "<h1><font color=\"black\">No players graded</font></h1>"; ?></td>
    <?php }}?>

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
