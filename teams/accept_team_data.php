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

    if ($result2==$result['reg_per_user']){
        $_SESSION['errors_team']= "You can only make " .$result['reg_per_user']. " registration/s for this hackathon. <br> You have reached your limit!. <br> Edit your registration/s here <a href='../events/registered_events.php'> Registered Events </a>";
        header("Location: teamReg.php");
        exit(); 
    }
    else if($result1){ 
        $_SESSION['errors_team']= "This team name already exists. Please chose another team name.";
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