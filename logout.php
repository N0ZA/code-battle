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

    header("Location: index.php");
    exit(); 
}
if (isset($_SESSION["user_isadmin"])){
        logout( $pdo);
    }


