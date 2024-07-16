<?php 

declare(strict_types=1);
require_once '../includes/dbh.inc.php';
require_once '../includes/config_session.inc.php';

if (isset($_POST['verify'])) {
    $ENTEREDotp = $_POST['USERotp'];
    if (isset($_SESSION['otp']) && isset($_SESSION['otp_time'])) {
        $otp=$_SESSION['otp'];
        $otp_time=$_SESSION['otp_time'];
        $otp_time_limit= 300; //5 minutes 
        
        if ($ENTEREDotp == $otp){    
            //otp matched
            if ((time() - $otp_time) <= $otp_time_limit){
                //otp isnt expired, add account to database
                $query="INSERT INTO registration_data(TRName,Email,Phone,School,username) VALUES (:TRName,:Email,:Phone,:School,:username);";
                $stmt=$pdo->prepare($query);
                $stmt->bindParam(":TRName",$_SESSION['TRName']);
                $stmt->bindParam(":Email",$_SESSION['Email']);
                $stmt->bindParam(":Phone",$_SESSION['Phone']);
                $stmt->bindParam(":School",$_SESSION['School']);
                $stmt->bindParam(":username",$_SESSION['username']);
                $stmt->execute();

                $query2="INSERT INTO login(username,pwd,admin) VALUES (:username,:password,:admin);";
                $stmt2=$pdo->prepare($query2);
                $stmt2->bindParam(":username",$_SESSION['username']);
                $stmt2->bindParam(":password",$_SESSION['password']);
                $stmt2->bindParam(":admin", $_SESSION['is_admin']);
                $stmt2->execute();

                session_unset();
                $_SESSION['Reg_CREATED']=1;
                header("Location: ../index.php");
            }
            else {
                session_unset();
                header("Location: signup.php");}
        } 
        else{
            $_SESSION['errors_signup']='Incorect OTP! Please Try Again';
            header("Location: enter_otp.php");
        }     
    }
    else {
        session_unset();
        header("Location: signup.php");}
}

function check_otp_errors(){
    if (isset($_SESSION['errors_signup'])) {
        $errors = $_SESSION['errors_signup'];
        echo '<p style="text-align: center; color: #ffffff;">' . $errors . '</p>';
        unset($_SESSION['errors_signup']);
    }
}
