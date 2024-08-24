<?php
require_once "includes/dbh.inc.php";
require_once 'includes/config_session.inc.php';
function logout(PDO $pdo) {
    $_SESSION = array();
    session_unset();
    session_destroy();

    $past = time() - 3600;
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, '', $past, '/');
    }   

        $query3 = "DELETE FROM hackathon_data 
               WHERE H_id NOT IN (SELECT H_id FROM judges_data) 
               OR H_id NOT IN (SELECT H_id FROM criteria_data)";
        // $query3 = "DELETE FROM hackathon_data WHERE NOT EXISTS ( SELECT NULL FROM criteria_data WHERE criteria_data.H_id = hackathon_data.H_id ) OR NOT EXISTS ( SELECT NULL FROM judges_data WHERE judges_data.H_id = hackathon_data.H_id )";
        $stmt3 = $pdo->prepare($query3);
        $stmt3->execute();
    header("Location: index.php");
    exit(); 
}
if (isset($_SESSION["user_isadmin"])){
        logout($pdo);
}