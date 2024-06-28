<?php
    declare(strict_types=1);
    require_once '../includes/dbh.inc.php';
    require_once '../includes/config_session.inc.php';
   
    $criterias=$_SESSION['criterias'];
    if ($_SESSION['is_team']==1){
        $q1="SELECT Score from team_scores where H_id=:H_id AND J_id=:J_id AND T_id=:T_id;";
        $stmt1=$pdo->prepare($q1);
        $stmt1->bindParam(":T_id",$_SESSION['T_id']);
    }else{
        $q1="SELECT Score from solo_scores where H_id=:H_id AND J_id=:J_id AND P_id=:P_id;";
        $stmt1=$pdo->prepare($q1);
        $stmt1->bindParam(":P_id",$_SESSION['P_id']);
    }

    $stmt1->bindParam(":H_id",$_SESSION['H_id']);
    $stmt1->bindParam(":J_id",$_SESSION['J_id']);
    $stmt1->execute();
    $score=$stmt1->fetch(PDO::FETCH_ASSOC);

    if(!empty($score)){
        if ($_SESSION['is_team']==1){
            $query2="UPDATE team_scores SET Score=:score WHERE H_id=:H_id AND J_id=:J_id AND T_id=:T_id AND CR_id=:CR_id";
        }else{
            $query2="UPDATE solo_scores SET Score=:score WHERE H_id=:H_id AND J_id=:J_id AND P_id=:P_id AND CR_id=:CR_id";
        }
    } else {
        if ($_SESSION['is_team']==1){
           
            $query2="INSERT INTO team_scores(H_id, J_id, CR_id, T_id, Score) VALUES (:H_id, :J_id, :CR_id, :T_id, :score)";
        }
        else{
            $query2="INSERT INTO solo_scores(H_id,J_id, CR_id, P_id, Score)VALUES(:H_id,:J_id,:CR_id, :P_id, :score)";
            // $query2="INSERT INTO solo_scores (H_id, J_id, CR_id, P_id, Score) VALUES (:H_id, :J_id, :CR_id, :P_id, :score)";
        }
    }
    
    foreach($criterias as $row){
        //making the input name attribute
        $Name=$row['CRName']."mark";
        // checking what value is posted for it and storing it in score
        $score=$_POST[$Name];
        // storing each criteria's criteria id
        $CR_id=$row['CR_id'];
        $stmt2=$pdo->prepare($query2);

        if ($_SESSION['is_team']==1){
            $stmt2->bindParam(":T_id",$_SESSION['T_id']);
        }else{
            $stmt2->bindParam(":P_id",$_SESSION['P_id']);
        }
        $stmt2->bindParam(":score",$score);
        $stmt2->bindParam(":H_id",$_SESSION['H_id']);
        $stmt2->bindParam(":J_id",$_SESSION['J_id']);
        $stmt2->bindParam(":CR_id",$CR_id);
        echo ($query4);
        $stmt2->execute();
    }
    
    unset($_SESSION['criterias']);
    unset($_SESSION['T_id']);
    unset($_SESSION['TName']);
    unset($_SESSION['P_id']);
    unset($_SESSION['PName']);
    header("Location: judge.php");
    exit();
    