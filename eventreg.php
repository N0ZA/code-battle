<?php
declare(strict_types=1);

require_once 'includes/dbh.inc.php';
require_once 'includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $_SESSION['is_team']= $_POST['is_team'];
    $_SESSION['H_id']= $_POST['H_id'];

    if ($_SESSION['is_team']) {
        header("Location: teams/teamReg.php");
    } 
    else {
        //Direct Solo Registration
        $_SESSION['currentMember'] = 1;
        $_SESSION['noMembers']=1;   
        header("Location: teams/memberReg.php");
    }
    exit();
}