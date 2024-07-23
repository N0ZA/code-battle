<?php
declare(strict_types=1);

require_once 'includes/dbh.inc.php';
require_once 'includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $_SESSION['is_team']= $_POST['is_team'];

    if ($_SESSION['is_team']) {
        $_SESSION['H_id']= $_POST['H_id'];
        header("Location: teams/teamReg.php");
    } 
    else {
        //Direct Solo Registration
        $_SESSION['currentMember'] = 1;
        $_SESSION['noMembers']=1;   
        $_SESION['H_id']= $_POST['H_id'];
        $_SESION['C_id']= $_POST['C_id'];
        header("Location: teams/memberReg.php");
    }
    exit();
}