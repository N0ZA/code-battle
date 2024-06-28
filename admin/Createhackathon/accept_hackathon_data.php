<?php

declare(strict_types=1);
require_once '../../includes/dbh.inc.php';
require_once '../../includes/config_session.inc.php';

// for sessions

    // if ($_SERVER["REQUEST_METHOD"]=="POST"){
    //         $_SESSION['HName']=$_POST["HName"];
    //         $_SESSION['HDate']=$_POST["HDate"];
    //         $_SESSION['HTime']=$_POST["HTime"];
    //         $_SESSION['MaxP']=$_POST["MaxP"];
    //         $_SESSION['Category']=$_POST["Category"];
    //         $_SESSION['H_created']=1;
    //         header("Location: AddJudge.php");
    //     }

// end of session

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $HName=$_POST["HName"];
    $HDate=$_POST["HDate"];
    $HTime=$_POST["HTime"];
    
    
    // $MaxP=$_POST["MaxP"];
    
    

    $query="INSERT INTO hackathon_data(HName,HDate,HTime) VALUES (:HName,:HDate,:HTime);";
    $stmt=$pdo->prepare($query);
    $stmt->bindParam(":HName",$HName);
    $stmt->bindParam(":HDate",$HDate);
    $stmt->bindParam(":HTime",$HTime);
    $stmt->execute();

    $query2="SELECT(H_id) from hackathon_data where HName=:HName;";
    $stmt=$pdo->prepare($query2);
    $stmt->bindParam(":HName",$HName);
    $stmt->execute();
    $H_id = $stmt->fetchColumn();

    $_SESSION['H_id']=$H_id;
    $_SESSION['HName']=$HName;

    $Category=$_POST["Category"];
    if (isset($_POST["Category"])) {
        $categories = $_POST["Category"];
        foreach ($categories as $selected) {
            switch ($selected) {
                case "Jr_Cadet":
                    $stmt = $pdo->prepare("UPDATE hackathon_data SET Jr_Cadet = 1 WHERE H_id = :H_id");
                    break;
                case "Jr_Captain":
                    $stmt = $pdo->prepare("UPDATE hackathon_data SET Jr_Captain = 1 WHERE H_id = :H_id");
                    break;
                case "Jr_Colonel":
                    $stmt = $pdo->prepare("UPDATE hackathon_data SET Jr_Colonel = 1 WHERE H_id = :H_id");
                    break;
                default:
                    break;
            }
            $stmt->bindParam(":H_id", $H_id);
            $stmt->execute();
        }
    }

    if(isset($_POST['team-type'])){
        $radiovalues=$_POST['team-type'];
        if($radiovalues=="team"){
            $stmt = $pdo->prepare("UPDATE hackathon_data SET is_team = 1 ,MaxP=:MaxP WHERE H_id = :H_id");
            $stmt->bindParam(":H_id", $H_id);
            $stmt->bindParam(":MaxP",$_POST["MaxP"]);
            $stmt->execute();
        }
        else{}
    }

    $_SESSION['H_created']=1;
    header("Location: AddJudge.php");

}
