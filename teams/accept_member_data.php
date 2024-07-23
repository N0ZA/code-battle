<?php
declare(strict_types=1);

require_once '../includes/dbh.inc.php';
require_once '../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['Discard'])) {
        header("Location: memberReg.php");
        exit();
    }   

    if ($_SESSION['is_team']==0){
        $T_id=NULL;
        $H_id = $_SESSION['H_id'];
        $C_id = $SESSION['C_id'];
        $Pname = $_POST['name'];
        $PEmail = $_POST['email'];
        $PSchool = $_POST['school'];

    }

    else{
    $teamName = $_SESSION['teamName'];
    $query = "SELECT T_id, H_id, C_id FROM team_data WHERE TName=:teamName";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":teamName", $teamName);
    $stmt->execute();
    $result = $stmt->fetch();
   
    $T_id = $result['T_id'];
    $H_id = $result['H_id'];
    $C_id = $result['C_id'];
    $Pname = $_POST['name'];
    $PEmail = $_POST['email'];
    $PSchool = $_POST['school'];

    $query1 = "INSERT INTO solo_data (H_id, C_id, T_id, Pname, PEmail, PSchool,Puser_id) VALUES (:H_id, :C_id, :T_id, :Pname, :PEmail, :PSchool,:Puser_id)";
    $stmt1 = $pdo->prepare($query1);
    $stmt1->bindParam(":H_id", $H_id);
    $stmt1->bindParam(":C_id", $C_id);
    $stmt1->bindParam(":T_id", $T_id);
    $stmt1->bindParam(":Pname", $Pname);
    $stmt1->bindParam(":PEmail", $PEmail);
    $stmt1->bindParam(":PSchool", $PSchool);
    $stmt1->bindParam(":Puser_id", $_SESSION['user_id']);
    //$stmt1->bindParam(":is_team", $_SESSION['is_team']);
    $stmt1->execute();

    $CName = ($C_id == 1) ? 'Jr_Cadet' : (($C_id == 2) ? 'Jr_Captain' : (($C_id == 3) ? 'Jr_Colonel' : 'Unknown'));

    $query2 = "UPDATE hackathon_data SET $CName = $CName - 1 WHERE H_id=:H_id";
    $stmt2 = $pdo->prepare($query2);
    $stmt2->bindParam(":H_id", $H_id);
    $stmt2->execute();

    if (isset($_POST['Next'])) {
        $_SESSION['currentMember']++;
        header("Location: memberReg.php");
        exit();
    } 
    else if (isset($_POST['Done'])) {
        unset($_SESSION['noMembers']);
        unset($_SESSION['currentMember']);
        header("Location: ../dashboard.php"); 
        exit();
    }
}