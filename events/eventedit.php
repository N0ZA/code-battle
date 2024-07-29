<?php

    declare(strict_types=1);

    require_once '../includes/dbh.inc.php';
    require_once '../includes/config_session.inc.php';

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

        $query1='SELECT T.TMembers,T.C_id, H.MaxP FROM team_data T
        JOIN hackathon_data H ON T.H_id = H.H_id
        WHERE T.TName=:TName AND H.H_id=:H_id';
        
        $stmt1 = $pdo->prepare($query1);
        $stmt1->bindParam(":TName", $TName);
        $stmt1->bindParam(":H_id", $_SESSION['H_id']);  
        $stmt1->execute();
        $result1=$stmt1->fetch();
        $C_id=$result1['C_id'];
        $CName = ($C_id == 1) ? 'Jr_Cadet' : (($C_id == 2) ? 'Jr_Captain' : (($C_id == 3) ? 'Jr_Colonel' : 'Unknown'));


        if ($result1[$CName]<1 || $result1['TMembers'] + 1 >= $result1['MaxP']) {
        
        } 
        if ($action=="add"){
            header("Location: ../teams/memberReg.php?source=eventedit");

        }
        else if  ($action=="edit"){

        }
        else if  ($action=="delete"){

        }
    
    }