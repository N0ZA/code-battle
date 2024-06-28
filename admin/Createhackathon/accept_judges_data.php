<?php

declare(strict_types=1);
require_once '../../includes/dbh.inc.php';
require_once '../../includes/config_session.inc.php';

// sessionbegin
    // if ($_SERVER["REQUEST_METHOD"]=="POST"){
        
    //     $_SESSION['judgescount']=$_POST["judgescount"];


    //     for($i=0;$i<$_SESSION['judgescount'];$i++){
    //         $_SESSION["JName_$i"]=$_POST["JName_".($i+1)];
    //         $_SESSION["JEmail_$i"]=$_POST["JEmail_".($i+1)];
    //         $_SESSION["JUsername_$i"]=$_POST["JUsername_".($i+1)];
    //         $password = $_POST["JPass_" . ($i + 1)];

    //         $options = [
    //             'cost' => 12
    //         ];

    //         $hashedPwd=password_hash($password,PASSWORD_BCRYPT,$options);
    //         $_SESSION["JPass_$i"]=$hashedPwd;

    //     }
    //     $_SESSION['H_judges_added']=1;
    //     header("Location: AddCriteria.php");
    // }
//sessionend

if ($_SERVER["REQUEST_METHOD"]=="POST"){

    $judgescount=$_POST["judgescount"];

    $query="Update hackathon_data set no_of_judges=:no_of_judges;";
    $stmt=$pdo->prepare($query);
    $stmt->bindParam(":no_of_judges",$judgescount);
    $stmt->execute();

    $query1="INSERT INTO judges_data(JName,JEmail,JUsername,H_id) VALUES (:JName,:JEmail,:JUsername,:H_id);";
    $query2="INSERT INTO login(username,pwd) VALUES (:JUsername,:JPass);";
    $stmt1=$pdo->prepare($query1);
    $stmt2=$pdo->prepare($query2);
    for($i=0;$i<$judgescount;$i++){
        $JName[$i]=$_POST["JName_".($i+1)];
        $JEmail[$i]=$_POST["JEmail_".($i+1)];
        $JUsername[$i]=$_POST["JUsername_".($i+1)];

        $stmt1->bindParam(":H_id",$_SESSION['H_id']); 
        $stmt1->bindParam(":JName",$JName[$i]);
        $stmt1->bindParam(":JEmail",$JEmail[$i]);
        $stmt1->bindParam(":JUsername",$JUsername[$i]);

        $JPass[$i]=$_POST["JPass_".($i+1)];
        $options = [
            'cost' => 12
        ];
        $hashedPwd=password_hash($JPass[$i],PASSWORD_BCRYPT,$options);
        $stmt2->bindParam(":JPass",$hashedPwd);
        $stmt2->bindParam(":JUsername",$JUsername[$i]);

        
        $stmt1->execute();
        $stmt2->execute();

        $query2="SELECT(J_id) from judges_data where JName=:JName;";
        $stmt=$pdo->prepare($query2);
        $stmt->bindParam(":JName",$JName[$i]);
        $stmt->execute();
        $J_id[$i] = $stmt->fetchColumn();

        $_SESSION['J_id']=$J_id[$i];

        $query4="select C_id,CName from category where CName=:CName;";
        $stmt4=$pdo->prepare($query4);

        $query3="INSERT INTO judges_category(H_id,J_id,username,C_id,CName) VALUES (:H_id,:J_id,:username,:C_id,:CName);";
        $stmt3=$pdo->prepare($query3);
        $stmt3->bindParam(":H_id",$_SESSION['H_id']);
        $stmt3->bindParam(":J_id",$J_id[$i]);
        $stmt3->bindParam(":username",$JUsername[$i]);
        
        $c1='Jr_Cadet';
        $c2='Jr_Captain';
        $c3='Jr_Colonel';

        if (isset($_POST["Jr_Cadet" . ($i + 1)])) {
            $stmt4->bindParam(":CName",$c1);
            $stmt4->execute();
            $result = $stmt4->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $C_id = $result['C_id'];
                $CName = $result['CName'];
            }
         
            $stmt3->bindParam(":C_id",$C_id);
            $stmt3->bindParam(":CName",$CName);
            $stmt3->execute();
            
        }
        if (isset($_POST["Jr_Captain" . ($i + 1)])) {
            $stmt4->bindParam(":CName",$c2);
            $stmt4->execute();
            $result = $stmt4->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $C_id = $result['C_id'];
                $CName = $result['CName'];
            }
         
            $stmt3->bindParam(":C_id",$C_id);
            $stmt3->bindParam(":CName",$CName);
            $stmt3->execute();
        }
        if (isset($_POST["Jr_Colonel" . ($i + 1)])) {
            $stmt4->bindParam(":CName",$c3);
            $stmt4->execute();
            $result = $stmt4->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $C_id = $result['C_id'];
                $CName = $result['CName'];
            }
         
            $stmt3->bindParam(":C_id",$C_id);
            $stmt3->bindParam(":CName",$CName);
            $stmt3->execute();
        }
    }

    $_SESSION['H_judges_added']=1;
    header("Location: AddCriteria.php");
}
