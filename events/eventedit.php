<?php

    declare(strict_types=1);

    require_once '../includes/dbh.inc.php';
    require_once '../includes/config_session.inc.php';

    if ($_SERVER['REQUEST_METHOD']=='GET') {
        $_SESSION['TName'] = isset($_GET['team']) ? $_GET['team']:  $_SESSION['TName'];
        $P_id= isset($_GET['solo']) ? $_GET['solo'] :$_GET['Solo']; ;
        $action = $_GET['action'];
        echo $_SESSION['TName'];

        if ($action=="add"){
            $_SESSION['new_TM']=1;
            header("Location: ../teams/memberReg.php?source=eventedit");
        }
        //deleting a team 
        else if  ($action=="delete"){
            $query1='DELETE FROM team_data WHERE TName=:TName and H_id=:H_id and Tuser_id=:user_id ';
            $stmt1=$pdo->prepare($query1);
            $stmt1->bindParam(":user_id",$_SESSION['user_id']);
            $stmt1->bindParam(":H_id",$_SESSION['H_id']);   
            $stmt1->bindParam(":TName", $_SESSION['TName']);
            $stmt1->execute();
            $result1=$stmt1->fetch();

            if ($result1['TName']!=$_SESSION['TName']){
                header("Location: ../error.html");
            }
            unset($_SESSION['TName']);
            header("Location: team_details.php");
        }
        //deleting a member of team or solo
        else if  ($action=="Sdelete"){
            //for team decreement the count as well
            if ($_SESSION['is_team']==1){
                $query1='DELETE FROM solo_data WHERE P_id=:P_id and H_id=:H_id and Tuser_id=:user_id ';
                $stmt1=$pdo->prepare($query1);
                $stmt1->bindParam(":P_id", $P_id);
                $stmt1->bindParam(":user_id",$_SESSION['user_id']);
                $stmt1->bindParam(":H_id",$_SESSION['H_id']);   
                $stmt1->execute();
                $result1=$stmt1->fetch();

                if ($result1['P_id']!= $P_id){
                    header("Location: ../error.html");
                }
                $query2="UPDATE team_data SET TMembers=TMembers-1 WHERE TName=:TName and H_id=:H_id and Tuser_id=:user_id ";
                $stmt2= $pdo->prepare($query2);
                $stmt2->bindParam(":TName", $_SESSION['TName']);
                $stmt2->bindParam(":user_id",$_SESSION['user_id']);
                $stmt2->bindParam(":H_id",$_SESSION['H_id']);   
                $stmt2->execute();
                unset($_SESSION['TName']);
                header("Location: team_details.php");
            }
            //for solo just delete using pid
            else if ($_SESSION['is_team']==0){ 
                $query1='DELETE FROM solo_data WHERE P_id=:P_id and H_id=:H_id and Puser_id=:user_id ';
                $stmt1=$pdo->prepare($query1);
                $stmt1->bindParam(":P_id", $P_id);
                $stmt1->bindParam(":user_id",$_SESSION['user_id']);
                $stmt1->bindParam(":H_id",$_SESSION['H_id']);   
                $stmt1->execute();
                $result1=$stmt1->fetch();
                if ($result1['P_id']!= $P_id){
                    header("Location: ../error.html");
                }
                header("Location: member_details.php");
            }
        }
        else if  ($action=="edit"){
            header("Location: member_details_edited.php");
        }
        else if  ($action=="Sedit"){
            $_SESSION['new_TM']=2;
            header("Location: ../teams/memberReg.php?S=" .$P_id);
        }
    
    }