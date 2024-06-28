<?php
require_once "../includes/dbh.inc.php";
function open_create_hackathon() {
    if (!isset($_SESSION['H_created'])) {
        header("Location: Createhackathon/HCreate.php");
        die(); 
    } elseif (!isset($_SESSION['H_judges_added'])) {
        header("Location: Createhackathon/AddJudge.php");
        die(); 
    } elseif (!isset($_SESSION['H_criteria_added'])) {
        header("Location: Createhackathon/AddCriteria.php");
        die(); 
    } 
}
open_create_hackathon();