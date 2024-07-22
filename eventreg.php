<?php
declare(strict_types=1);

require_once 'includes/dbh.inc.php';
require_once 'includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $is_team= $_POST['is_team'];

    if ($is_team) {
        header("Location: teams/teamReg.php");
    } else {
        $_SESSION['currentMember'] = 1;
        $_SESSION['noMembers']=1;
        header("Location: teams/memberReg.php");
    }
    exit();
}