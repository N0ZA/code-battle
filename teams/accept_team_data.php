<?php
declare(strict_types=1);

require_once '../includes/dbh.inc.php';
require_once '../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    //store the form enteries 
    $_SESSION['teamName'] = $_POST['teamName'];
    $_SESSION['noMembers'] = $_POST['noMembers'];
    $category=$_POST['category'];
    $maxP = $_POST['maxP'];
    $jrCadet=$_POST['jrCadet'];
    $jrCaptain=$_POST['jrCaptain'];
    $jrColonel=$_POST['jrColonel'];

    $hackathon=$_SESSION['H_id'];

    if ($category == 1 && $_SESSION['noMembers']> $jrCadet) {
        $_SESSION['errors_signup']= 'Members exceed the limit for the Cadet category.' ;} 
    elseif ($category == 2 && $_SESSION['noMembers']> $jrCaptain) {
        $_SESSION['errors_signup']= 'Members exceed the limit for the Captain category.';} 
    elseif ($category == 3 && $_SESSION['noMembers']> $jrColonel) {
        $_SESSION['errors_signup']= 'Members exceed the limit for the Colonel category.';} 
    elseif ($_SESSION['noMembers']> $maxP) {
        $_SESSION['errors_signup']= 'The hackathon allows only ' . $maxP . ' members';}
    else{
        $query="INSERT INTO team_data(H_id,C_id,TName,TMembers,Tuser_id) VALUES (:hackathon,:category,:teamName,:noMembers,:Tuser_id);";
        $stmt=$pdo->prepare($query);
        $stmt->bindParam(":hackathon",$hackathon);
        $stmt->bindParam(":category",$category);
        $stmt->bindParam(":teamName",$_SESSION['teamName']);
        $stmt->bindParam(":noMembers",$_SESSION['noMembers']);
        $stmt->bindParam(":Tuser_id",$_SESSION['user_id']);
        $stmt->execute();

        $_SESSION['currentMember'] = 1;
        $_SESSION['T_CREATED']=1;
        header("Location: memberReg.php");
        exit();
    }

    if (!empty($_SESSION['errors_signup'])) {
        header("Location: teamReg.php");
        exit();
    }    
}

function check_team_errors(){
    if (isset($_SESSION['errors_signup'])) {
        $errors=$_SESSION['errors_signup'];
        echo '<p style="text-align: center; color: #F73634;">' . $errors . '</p>';}
        unset($_SESSION['errors_signup']); 
        unset($_SESSION['noMembers']);
}