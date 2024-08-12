<?php

    declare(strict_types=1);

    require_once '../includes/dbh.inc.php';
    require_once '../includes/config_session.inc.php';

    if ($_SERVER['REQUEST_METHOD']=='GET') {
        $_SESSION['TName'] = isset($_GET['team']) ? $_GET['team']:  $_SESSION['TName'];
        $PName=$_GET['solo'];
        $P_id=$_GET['Solo'];
        $action = $_GET['action'];
        echo $_SESSION['TName'];

        if ($action=="add"){
            $_SESSION['new_TM']=1;
            header("Location: ../teams/memberReg.php?source=eventedit");
        }
        else if  ($action=="delete"){
            $query1='DELETE FROM team_data WHERE TName=:TName';
            $stmt1=$pdo->prepare($query1);
            $stmt1->bindParam(":TName", $_SESSION['TName']);
            $stmt1->execute();
            $result1=$stmt1->fetch();
            unset($_SESSION['TName']);
            header("Location: team_details.php");
        }
        else if  ($action=="Sdelete"){
            $query1='DELETE FROM solo_data WHERE PName=:PName';
            $stmt1=$pdo->prepare($query1);
            $stmt1->bindParam(":PName", $PName);
            $stmt1->execute();
            $result1=$stmt1->fetch();

            $query2="UPDATE team_data SET TMembers=TMembers-1 WHERE TName=:TName";
            $stmt2= $pdo->prepare($query2);
            $stmt2->bindParam(":TName", $_SESSION['TName']);
            $stmt2->execute();
            unset($_SESSION['TName']);
            header("Location: team_details.php");
        }
        else if  ($action=="edit"){
            header("Location: member_details.php");
        }
        else if  ($action=="Sedit"){
            $_SESSION['new_TM']=2;
            header("Location: ../teams/memberReg.php?S=" .$P_id);
        }
    
    }