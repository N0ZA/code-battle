<?php
    declare(strict_types=1);

    require_once '../includes/dbh.inc.php';
    require_once '../includes/config_session.inc.php';

    $qrData = isset($_GET['qrData']) ? $_GET['qrData'] : '';

    echo $qrData;
    $is_team=$qrData[0]; // First letter T or P
    $val=substr($qrData, 1);

    if ($is_team=='T'){
        $T_id=$val;
        $query="UPDATE team_data SET Tchecked_in=1 WHERE T_id=:T_id";
        $stmt=$pdo->prepare($query);
        $stmt->bindParam(":T_id",$T_id);
        $stmt->execute();
        
        $query1="UPDATE solo_data SET Pchecked_in=1 WHERE T_id=:T_id";
        $stmt1=$pdo->prepare($query1);
        $stmt1->bindParam(":T_id",$T_id);
        $stmt1->execute();

    }
    else if ($is_team=='P'){
        $P_id=$val;
        $query="UPDATE solo_data SET Pchecked_in=1 WHERE T_id is NULL and P_id=:P_id";
        $stmt=$pdo->prepare($query);
        $stmt->bindParam(":P_id",$P_id);
        $stmt->execute();

    }

    header("Location: qr_scanner.php?status=checked_in");
    exit();
