<?php
    declare(strict_types=1);

    require_once '../includes/dbh.inc.php';
    require_once '../includes/config_session.inc.php';

    
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $qrData = isset($_GET['qrData']) ? $_GET['qrData'] : $_GET['Data'];
        $is_team=$qrData[0]; // First letter T or P
        $val=substr($qrData, 1);

        if ($is_team=='T'){
            $T_id=$val;
            //if team already set to 1
            $query = "SELECT * FROM team_data WHERE T_id=:T_id";
            $stmt=$pdo->prepare($query);
            $stmt->bindParam(":T_id",$T_id);
            $stmt->execute();
            $result=$stmt->fetch();
            //getting members data
            $query2 = "SELECT * FROM solo_data WHERE T_id=:T_id";
            $stmt2=$pdo->prepare($query2);
            $stmt2->bindParam(":T_id",$T_id);
            $stmt2->execute();
            $result2=$stmt2->fetchAll();

            if ($result['Tchecked_in']==1) {
                header("Location: qr_scanner.php?status=already_checked_in");
                exit();
            }
            //WHEN check in button is presses
            if (isset($_GET['Data'])) {
                //it not already set, then set team and its member to 1
                $query="UPDATE team_data SET Tchecked_in=1 WHERE T_id=:T_id";
                $stmt=$pdo->prepare($query);
                $stmt->bindParam(":T_id",$T_id);
                $stmt->execute();
                
                $query1="UPDATE solo_data SET Pchecked_in=1 WHERE T_id=:T_id";
                $stmt1=$pdo->prepare($query1);
                $stmt1->bindParam(":T_id",$T_id);
                $stmt1->execute();
                header("Location: qr_scanner.php?status=checked_in");
                exit();
            }
            else{   //to display team and their details
                $_SESSION['details']=$result;
                $_SESSION['mem_details']=$result2;
                header("Location: qr_scanner.php");
                exit();
            }

        }
        else if ($is_team=='P'){
            $P_id=$val;
            //if member already set to 1
            $query="SELECT * FROM solo_data WHERE P_id=:P_id AND T_id IS NULL";
            $stmt=$pdo->prepare($query);
            $stmt->bindParam(":P_id",$P_id);
            $stmt->execute();
            $result=$stmt->fetch();
            if ($result['Pchecked_in']==1) {
                header("Location: qr_scanner.php?status=already_checked_in");
                exit();
            }
            //WHEN check in button is presses
            if (isset($_GET['Data'])) {
                //it not already set, then set to 1
                $query="UPDATE solo_data SET Pchecked_in=1 WHERE T_id is NULL and P_id=:P_id";
                $stmt=$pdo->prepare($query);
                $stmt->bindParam(":P_id",$P_id);
                $stmt->execute();
                header("Location: qr_scanner.php?status=checked_in");
                exit();
            }
            else{   //to display solo member details
                $_SESSION['details']=$result;
                header("Location: qr_scanner.php");
                exit();
            }

        }
}