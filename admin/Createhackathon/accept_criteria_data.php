<?php

declare(strict_types=1);
require_once '../../includes/dbh.inc.php';
require_once '../../includes/config_session.inc.php';

  
if ($_SERVER["REQUEST_METHOD"]=="POST"){
    if(isset($_POST['criteria'])) {
        $criterias = $_POST['criteria'];
        $weights=$_POST['weights'];
        // var_dump($weights);
        $query1="INSERT INTO criteria_data(CRName,CR_id,CRWeight,H_id) VALUES (:CRName,:CR_id,:CRWeight,:H_id);";
        $stmt1=$pdo->prepare($query1);

        
        foreach($criterias as $criteria){
            $stmt1->bindParam(":CRName",$criteria);
            $weight=$weights[$criteria];
            $w=intval($weight);
            $stmt1->bindParam(":CRWeight",$w);
            $stmt1->bindParam(":H_id",$_SESSION['H_id']);
            $query2="SELECT CR_id from criteria where CRName=:CRName";
            $stmt2=$pdo->prepare($query2);
            $stmt2->execute([":CRName" => $criteria]);
            $CR_id=$stmt2->fetchColumn();
            $stmt1->bindParam(":CR_id",$CR_id);
            $stmt1->execute();
        }
        $_SESSION['H_criteria_added']=1;
        header("Location: completed.php");
    }
}

//session start
    // if ($_SERVER["REQUEST_METHOD"]=="POST"){
    
        
    //     $_SESSION['CName1']=$_POST["CName1"];
    //     $_SESSION['CWeight1']=$_POST["CWeight1"];
    //     $_SESSION['CName2']=$_POST["CName2"];
    //     $_SESSION['CWeight2']=$_POST["CWeight2"];
    //     $_SESSION['CName3']=$_POST["CName3"];
    //     $_SESSION['CWeight3']=$_POST["CWeight3"];
        
    //     $_SESSION['H_criteria_added']=1;
    //     header("Location: completed.php");
    // }
//session end

// if ($_SERVER["REQUEST_METHOD"]=="POST"){
    
//     $query1="INSERT INTO criteria_data(CRName,CRWeight,H_id) VALUES (:CRName,:CRWeight,:H_id);";
//     $stmt=$pdo->prepare($query1);
    
//     for($i=1;$i<6;$i++){
//         $CRName=$_POST["CName".$i];
//         $CRWeight=$_POST["CWeight".$i];
//         $stmt->bindParam(":CRName",$CRName);
//         $stmt->bindParam(":CRWeight",$CRWeight);
//         $stmt->bindParam(":H_id",$_SESSION['H_id']);
//         $stmt->execute();
        
//     }
    
//     $_SESSION['H_criteria_added']=1;

//     unset($_SESSION['HName']);
//     unset($_SESSION['H_id']);
//     unset($_SESSION['H_created']);
//     unset($_SESSION['H_judges_added']);
//     unset($_SESSION['H_criteria_added']);
//     header("Location: ../admin.php");
// }
 