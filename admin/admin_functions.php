<?php
require_once "../includes/dbh.inc.php";


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_isadmin']) || !isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}
