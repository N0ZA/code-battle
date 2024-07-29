<?php

    declare(strict_types=1);

    require_once 'includes/dbh.inc.php';
    require_once 'includes/config_session.inc.php';

    if ($_SERVER['REQUEST_METHOD']=='GET') {
        $_SESSION['TName'] = $_GET['team'];
        $action = $_GET['action'];

        $query='SELECT * FROM team_data WHERE TName=:TName';
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":TName", $_SESSION['TName']);
        $stmt->execute();
        $result=$stmt->fetch();

        $T_id=$result['T_id'];
        $C_id=$result['C_id']; 
        echo  "<br>" .$T_id;
        echo  "<br>" .$C_id;
        echo  "<br>" .$_SESSION['H_id'];
        echo  "<br>" .$_SESSION['is_team'];
        if ($action=="add"){
            header("Location: teams/memberReg.php?source=eventedit");

        }
        else if  ($action=="edit"){

        }
        else if  ($action=="delete"){

        }
    
    }