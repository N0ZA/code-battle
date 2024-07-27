<?php
    declare(strict_types=1);

    require_once 'includes/dbh.inc.php';
    require_once 'includes/config_session.inc.php';

    if ($_SERVER["REQUEST_METHOD"]=="POST"){
        echo "hii";
        $_SESSION['H_id']= $_POST['H_id'];
        $_SESSION['is_team']=$_POST['is_team'];
        if (isset($_POST['Register'])) {
            if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
                header("Location: index.php");
                exit();
            }
           
            $query='SELECT COUNT(*) FROM event_reg WHERE user_id=:user_id AND H_id=:H_id';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":H_id",$_SESSION['H_id']);
            $stmt->bindParam(":user_id",$_SESSION['user_id']);
            $stmt->execute();
            $result=$stmt->fetchColumn();     //fetchColumn gives count directly

            if ($result==0){
                $query1='INSERT INTO event_reg (user_id,H_id) VALUES (:user_id, :H_id)';
                $stmt1 = $pdo->prepare($query1);
                $stmt1->bindParam(":H_id", $_POST['H_id']);
                $stmt1->bindParam(":user_id", $_SESSION['user_id']);
                $stmt1->execute();
            }
            header("Location: registered_events.php");
            exit();
        }

        elseif (isset($_POST['Add_Team'])){
            header("Location: teams/teamReg.php");
            exit();
        }
        
        elseif (isset($_POST['Add_Member'])) {  //Direct to solo registration
            header("Location: teams/memberReg.php");
            exit();
        }
    }