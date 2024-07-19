<?php
declare(strict_types=1);

require_once '../includes/dbh.inc.php';
require_once '../includes/config_session.inc.php';

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    //store the form enteries 
    $_SESSION['teamName'] = $_POST['teamName'];
    $_SESSION['noMembers'] = $_POST['noMembers'];
    $category=$_POST['category'];
    //when hackathon selected, its h_ID will need to be made as session variable
    $hackathon='276';

    $maxP = $_POST['maxP'];

    if ($_SESSION['noMembers'] > $maxP){
        $_SESSION['errors_signup'] = 'The hackathon allows only ' . $maxP . ' members';
        header("Location:teamRegistration.php");
    }
    else{
        $query="INSERT INTO team_data(H_id,C_id,TName,TMembers) VALUES (:hackathon,:category,:teamName,:noMembers);";
        $stmt=$pdo->prepare($query);
        $stmt->bindParam(":hackathon",$hackathon);
        $stmt->bindParam(":category",$category);
        $stmt->bindParam(":teamName",$_SESSION['teamName']);
        $stmt->bindParam(":noMembers",$_SESSION['noMembers']);
        $stmt->execute();

        $_SESSION['T_CREATED']=1;
        header("Location: memberRegistration.php");
        exit();
    }
}

function check_team_errors(){
    if (isset($_SESSION['errors_signup'])) {
        $errors=$_SESSION['errors_signup'];
        echo '<p style="text-align: center; color: #F73634;">' . $errors . '</p>';}
        unset($_SESSION['errors_signup']); 
}