<?php
declare(strict_types=1);

require_once '../includes/dbh.inc.php';
require_once '../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Pname = $_POST['name'];
    $PEmail = $_POST['email'];
    $PSchool = $_POST['school'];
    
    if ($_SESSION['is_team']==0){       //solo regis-set variables
        $T_id=NULL;
        $H_id = $_SESSION['H_id'];
        $C_id = $_POST['category'];
    }

    else if ($_SESSION['is_team']) {    //team regis-set variables
        $teamName = $_SESSION['teamName'];
        $query1 = "SELECT T_id, H_id, C_id FROM team_data WHERE TName=:teamName";
        $stmt1 = $pdo->prepare($query1);
        $stmt1->bindParam(":teamName", $teamName);
        $stmt1->execute();
        $result1 = $stmt1->fetch();
       
        $T_id = $result1['T_id'];
        $H_id = $result1['H_id'];
        $C_id = $result1['C_id'];
        $CName = ($C_id == 1) ? 'Jr_Cadet' : (($C_id == 2) ? 'Jr_Captain' : (($C_id == 3) ? 'Jr_Colonel' : 'Unknown'));

        
        if (isset($_POST['Add_Member'])) {  
            $query2='SELECT T.TMembers,H.MaxP, H.' . $CName . ' FROM team_data T
                JOIN hackathon_data H ON T.H_id = H.H_id
                WHERE T.T_id=:T_id AND H.H_id=:H_id';
                 
            $stmt2 = $pdo->prepare($query2);
            $stmt2->bindParam(":T_id", $T_id);
            $stmt2->bindParam(":H_id", $H_id);  
            $stmt2->execute();
            $result2=$stmt2->fetch();

            if ($result2['TMembers']+1 >= $result2[$CName]){
                $_SESSION['errors_mem']="Exceeded the available seats limit. Press Done";
             }
            else if ($result2['TMembers']+1 >= $result2['MaxP']){
                $_SESSION['errors_mem']="Cannot add more members MAX: " .$result2['MaxP']. ".Press Done";
            }
        }
    }
    //check for both solo registration and team members
    $query='SELECT * FROM solo_data WHERE T_id=:T_id and PName=:Pname';
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":Pname", $Pname);
    $stmt->bindParam(":T_id", $T_id);
    $stmt->execute();
    $result = $stmt->fetch();  

    if ($result){
        $_SESSION['errors_mem']='A registration with this name already exists for this team';}

    if (!empty($_SESSION['errors_mem'])) {
        header("Location: memberReg.php");
        exit();
    }   
    else{
        $query3 = "INSERT INTO solo_data (H_id, C_id, T_id, Pname, PEmail, PSchool,Puser_id) VALUES (:H_id, :C_id, :T_id, :Pname, :PEmail, :PSchool,:Puser_id)";
        $stmt3 = $pdo->prepare($query3);
        $stmt3->bindParam(":H_id", $H_id);
        $stmt3->bindParam(":C_id", $C_id);
        $stmt3->bindParam(":T_id", $T_id);
        $stmt3->bindParam(":Pname", $Pname);
        $stmt3->bindParam(":PEmail", $PEmail);
        $stmt3->bindParam(":PSchool", $PSchool);
        $stmt3->bindParam(":Puser_id", $_SESSION['user_id']);
        $stmt3->execute();
    
        $CName = ($C_id == 1) ? 'Jr_Cadet' : (($C_id == 2) ? 'Jr_Captain' : (($C_id == 3) ? 'Jr_Colonel' : 'Unknown'));
        $query4 = "UPDATE hackathon_data SET $CName = $CName - 1 WHERE H_id=:H_id";
        $stmt4= $pdo->prepare($query4);
        $stmt4->bindParam(":H_id", $_SESSION['H_id']);
        $stmt4->execute();

        $query5="UPDATE team_data SET TMembers=TMembers+1 WHERE T_id=:T_id";
        $stmt5= $pdo->prepare($query5);
        $stmt5->bindParam(":T_id", $T_id);
        $stmt5->execute();
    
        if (isset($_POST['Add_Member'])) {
            header("Location: memberReg.php");
            exit();
        } 
        elseif (isset($_POST['Done'])) {
            unset($_SESSION['teamName']);
            header("Location: ../registered_events.php");
            exit();
        }      
    }
}
    function check_mem_errors(){
        if (isset($_SESSION['errors_mem'])) {
            echo '<p style="text-align: center; color: #F73634;">' . $_SESSION['errors_mem'] . '</p>';
            unset($_SESSION['errors_mem']); }
    }
    