<?php

declare(strict_types=1);
require_once '../includes/dbh.inc.php';
require_once '../includes/config_session.inc.php';

function discarding(PDO $pdo){
    $query3 = "DELETE FROM hackathon_data 
           WHERE H_id NOT IN (SELECT H_id FROM judges_data) 
           OR H_id NOT IN (SELECT H_id FROM criteria_data)";
    // $query3 = "DELETE FROM hackathon_data WHERE NOT EXISTS ( SELECT NULL FROM criteria_data WHERE criteria_data.H_id = hackathon_data.H_id ) OR NOT EXISTS ( SELECT NULL FROM judges_data WHERE judges_data.H_id = hackathon_data.H_id )";
    $stmt3 = $pdo->prepare($query3);
    $stmt3->execute();
    unset($_SESSION['H_created']);
    unset($_SESSION['H_judges_added']);
    unset($_SESSION['H_criteria_added']);
    header("Location: admin.php");
}

discarding($pdo);
