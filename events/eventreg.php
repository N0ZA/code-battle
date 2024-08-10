<?php
    declare(strict_types=1);

    require_once '../includes/dbh.inc.php';
    require_once '../includes/config_session.inc.php';

    //checks if you already signed in and you press register or if you just logged in 
    if (($_SERVER["REQUEST_METHOD"]=="POST") || (isset($_GET["login"]) && $_GET["login"] === "success") || ($_SERVER['REQUEST_METHOD']=='GET')) {
        if (($_SERVER["REQUEST_METHOD"]=="POST") || (isset($_GET["H"]))){
            //h_id and is_team taken from dashboard page
            $_SESSION['H_id']=isset($_POST['H_id'])? $_POST['H_id'] : $_GET['H'];
            $_SESSION['is_team']=isset($_POST['is_team'])? $_POST['is_team']: $_GET['T'];
            if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
                header("Location: ../index.php?H=" . $_SESSION['H_id'] . "&T=" . $_SESSION['is_team']);  // if user is not logged in and they press register, take them to log in page
                exit();
            }
            else if (isset($_POST['Add_Team'])){         //Direct to team registration
                $_SESSION['new_TM']=1;
                header("Location: ../teams/teamReg.php");
                exit();
            }
            elseif (isset($_POST['Add_Member'])) {      //Direct to solo registration
                $_SESSION['new_TM']=1;
                header("Location: ../teams/memberReg.php");
                exit();
            }
            else if (isset($_POST['Edit_Teams'])){
                header("Location: team_details.php");   //shows all teams registered
                exit();
            }
            else if (isset($_POST['Edit_Members'])){
                header("Location: member_details.php"); //shows all members registered
                exit();
            }
            else if (isset($_POST['Register'])){
                //insert data into event_reg table---below
            }
           
        }
        $query='SELECT COUNT(*) FROM event_reg WHERE user_id=:user_id AND H_id=:H_id';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":H_id",$_SESSION['H_id']);
        $stmt->bindParam(":user_id",$_SESSION['user_id']);
        $stmt->execute();
        $result=$stmt->fetchColumn();     //fetchColumn gives count directly

        if ($result==0){            //to make sure, if event already exists, we dont have to insert again
            $query1='INSERT INTO event_reg (user_id,H_id) VALUES (:user_id, :H_id)';
            $stmt1 = $pdo->prepare($query1);
            $stmt1->bindParam(":H_id", $_SESSION['H_id']);
            $stmt1->bindParam(":user_id", $_SESSION['user_id']);
            $stmt1->execute();
        }
        header("Location: registered_events.php");         
        exit();
    }
