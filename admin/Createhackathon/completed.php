<?php
    require_once '../../includes/config_session.inc.php';
    function Hcreationsuccess(){
    unset($_SESSION['HName']);
    unset($_SESSION['H_id']);
    unset($_SESSION['H_created']);
    unset($_SESSION['H_judges_added']);
    unset($_SESSION['H_criteria_added']);
    header("Location: ../admin.php");
    }
    Hcreationsuccess();
?>



        declare(strict_types=1);
        require_once '../../includes/dbh.inc.php';
        require_once '../../includes/config_session.inc.php';
        // require_once '../admin_functions.php';

        
        // echo "Welcome"."<br>";
        // echo $_SESSION['H_created']."<br>";
        // if(!isset($_SESSION['H_created'])){
        $query="INSERT INTO hackathon_data(HName,HDate,HTime,MaxP,Category) VALUES (:HName,:HDate,:HTime,:MaxP,:Category);";
        $stmt=$pdo->prepare($query);
        $stmt->bindParam(":HName",$_SESSION['HName']);
        $stmt->bindParam(":HDate",$_SESSION['HDate']);
        $stmt->bindParam(":HTime",$_SESSION['HTime']);
        $stmt->bindParam(":MaxP",$_SESSION['MaxP']);
        $stmt->bindParam(":Category",$_SESSION['Category']);
        
        $stmt->execute();

        $query1="SELECT(H_id) from hackathon_data where HName=:HName;";
        $stmt=$pdo->prepare($query1);

        $stmt->bindParam(":HName",$_SESSION['HName']);
        $stmt->execute();

        $_SESSION['H_id'] = $stmt->fetchColumn();

        // echo "SUCCESS1"."<br>";
        
        // }
        // if(!isset($_SESSION['H_judges_added'])){
            $query2="INSERT INTO login_data(JName,JEmail,JUsername,JPass,H_id,is_admin) VALUES (:JName,:JEmail,:JUsername,:JPass,:H_id,:is_admin);";
            $stmt=$pdo->prepare($query2);
            $zero=0;
            for($i=0;$i<$_SESSION['judgescount'];$i++){
                // echo $_SESSION['JName_$i'];

                $stmt->bindParam(":JName",$_SESSION["JName_$i"]);
                $stmt->bindParam(":JEmail",$_SESSION["JEmail_$i"]);
                $stmt->bindParam(":JUsername",$_SESSION["JUsername_$i"]);
                $stmt->bindParam(":JPass",$_SESSION["JPass_$i"]);
                $stmt->bindParam(":H_id",$_SESSION['H_id']);
                $stmt->bindParam(":is_admin",$zero);
                $stmt->execute();
            }

            

        // echo "SUCCESS2"."<br>";
        
        // }
        // if(!isset($_SESSION['H_criteria_added'])){

        $query3="INSERT INTO criteria_data(CName1,CWeight1,CName2,CWeight2,CName3,CWeight3,H_id) VALUES (:CName1,:CWeight1,:CName2,:CWeight2,:CName3,:CWeight3,:H_id);";
        $stmt=$pdo->prepare($query3);

        $stmt->bindParam(":CName1",$_SESSION['CName1']);
        $stmt->bindParam(":CWeight1",$_SESSION['CWeight1']);
        $stmt->bindParam(":CName2",$_SESSION['CName2']);
        $stmt->bindParam(":CWeight2",$_SESSION['CWeight2']);
        $stmt->bindParam(":CName3",$_SESSION['CName3']);
        $stmt->bindParam(":CWeight3",$_SESSION['CWeight3']);
        $stmt->bindParam(":H_id",$_SESSION['H_id']);
        $stmt->execute();
        // echo "SUCCESS3"."<br>";
      
        unset($_SESSION['H_judges_added']);
        unset($_SESSION['H_created']);
        unset($_SESSION['H_criteria_added']);
       
        header("Location: ../admin.php");
        

