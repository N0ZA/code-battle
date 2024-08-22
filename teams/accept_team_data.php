<?php
declare(strict_types=1);

require_once '../includes/dbh.inc.php';
require_once '../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    //store the form enteries 
    $_SESSION['TName'] = $_POST['TName'];
    $category=$_POST['category'];
    $hackathon=$_SESSION['H_id'];
    $school = $_POST['school'];
    $TMembers=0;

    $query = "SELECT * FROM hackathon_data WHERE H_id=:H_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":H_id", $hackathon);
    $stmt->execute();
    $result=$stmt->fetch();

    //get team details
    $query1='SELECT * FROM team_data WHERE H_id=:H_id and Tuser_id=:user_id';
    $stmt1=$pdo->prepare($query1);
    $stmt1->bindParam(":user_id",$_SESSION['user_id']);
    $stmt1->bindParam(":H_id",$_SESSION['H_id']);
    $stmt1->execute();
    $teams=$stmt1->fetchAll();
    
    //deleting teams tht have  less than 2 members
    foreach ($teams as $team) {
        if ($team['TMembers']<2){
            $query4='DELETE FROM team_data WHERE T_id=:T_id';
            $stmt4=$pdo->prepare($query4);
            $stmt4->bindParam(":T_id",$team['T_id']);
            $stmt4->execute();
            unset($_SESSION['TName']);
        }
    }
    //tname is unique at event level
    $query1 = "SELECT * FROM team_data WHERE TName=:TName AND H_id=:H_id";
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindParam(":TName", $_SESSION['TName']);
    $stmt1->bindParam(":H_id", $hackathon);
    $stmt1->execute();
    $result1=$stmt1->fetch();

    $query2 = "SELECT * FROM team_data WHERE Tuser_id=:user_id AND H_id=:H_id";
    $stmt2 = $pdo->prepare($query2);
    $stmt2->bindParam(":user_id", $_SESSION['user_id']);
    $stmt2->bindParam(":H_id", $hackathon);
    $stmt2->execute();
    $result2=$stmt2->rowCount();

    $query3="SELECT * FROM team_data WHERE Tschool=:school AND H_id=:H_id";
    $stmt3=$pdo->prepare($query3);
    $stmt3->bindParam(":school", $school);
    $stmt3->bindParam(":H_id", $hackathon);
    $stmt3->execute();
    $result3=$stmt3->rowCount();

    if ($result3==$result['reg_per_schl']){
        $_SESSION['errors_team']=   $school. " can only make " .$result['reg_per_schl']. " registration/s for this hackathon.";
        header("Location: teamReg.php");
        exit(); 
    }
    //else if ($result2==$result['reg_per_user']){
    //    $_SESSION['errors_team']= "You can only make " .$result['reg_per_user']. " registration/s for this hackathon. <br> You have reached your limit!";
    //    header("Location: teamReg.php");
     //   exit(); 
    //}
    else if($result1){ 
        $_SESSION['errors_team']= "This team name already exists. <br>Please chose another team name.";
        header("Location: teamReg.php");
        exit(); 
    }  
    else{
        $query="INSERT INTO team_data(H_id,C_id,TName,TSchool,TMembers,Tuser_id) VALUES (:hackathon,:category,:TName,:TSchool,:TMembers,:Tuser_id);";
        $stmt=$pdo->prepare($query);
        $stmt->bindParam(":hackathon",$hackathon);
        $stmt->bindParam(":category",$category);
        $stmt->bindParam(":TName",$_SESSION['TName']);
        $stmt->bindParam(":TSchool",$school);
        $stmt->bindParam(":TMembers",$TMembers);
        $stmt->bindParam(":Tuser_id",$_SESSION['user_id']);
        $stmt->execute();
        
        header("Location: memberReg.php");
        exit(); 
    }
}

function check_team_errors(){
    if (isset($_SESSION['errors_team'])) {
        $errors=$_SESSION['errors_team'];
        echo '<p style="text-align: center; color: #F73634;">' . $errors . '</p>';}
        unset($_SESSION['errors_team']); 
}