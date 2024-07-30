<?php

    declare(strict_types=1);

    require_once '../includes/dbh.inc.php';
    require_once '../includes/config_session.inc.php';

    if ($_SERVER['REQUEST_METHOD']=='GET') {
        $_SESSION['TName'] = $_GET['team'];
        $PName=$_GET['solo'];
        $action = $_GET['action'];


        if ($action=="add"){
            header("Location: ../teams/memberReg.php?source=eventedit");
        }
        else if  ($action=="delete"){
            $query1='DELETE FROM team_data WHERE TName=:TName';
            $stmt1=$pdo->prepare($query1);
            $stmt1->bindParam(":TName", $_SESSION['TName']);
            $stmt1->execute();
            $result1=$stmt1->fetch();
            header("Location: team_details.php");
        }
        else if  ($action=="Sdelete"){
            $query1='DELETE FROM solo_data WHERE PName=:PName';
            $stmt1=$pdo->prepare($query1);
            $stmt1->bindParam(":PName", $PName);
            $stmt1->execute();
            $result1=$stmt1->fetch();
            header("Location: member_details.php");
        }
        else if  ($action=="edit"){


        }
    
    }