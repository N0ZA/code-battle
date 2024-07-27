<?php
declare(strict_types=1);

require_once '../includes/dbh.inc.php';
require_once '../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    //store the form enteries 
    $_SESSION['teamName'] = $_POST['teamName'];
    $category=$_POST['category'];
    $jrCadet=$_POST['jrCadet'];
    $jrCaptain=$_POST['jrCaptain'];
    $jrColonel=$_POST['jrColonel'];
    $hackathon=$_SESSION['H_id'];
    $TMembers=0;

    $query1 = "SELECT * FROM team_data WHERE TName=:teamName";
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindParam(":teamName", $_SESSION['teamName']);
    $stmt1->execute();
    $result1=$stmt1->fetch();

    if($result1){ 
        $_SESSION['errors_team']="The team '" .$_SESSION['teamName']. "' is already registered for this Hackathon";
        header("Location: teamReg.php");
        exit(); 
    }
    else{
        $query="INSERT INTO team_data(H_id,C_id,TName,TMembers,Tuser_id) VALUES (:hackathon,:category,:teamName,:TMembers,:Tuser_id);";
        $stmt=$pdo->prepare($query);
        $stmt->bindParam(":hackathon",$hackathon);
        $stmt->bindParam(":category",$category);
        $stmt->bindParam(":teamName",$_SESSION['teamName']);
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