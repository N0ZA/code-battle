<?php
declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

require_once '../includes/dbh.inc.php';
require_once '../includes/config_session.inc.php';

if (isset($_POST['SignUp'])) {
    //store the form enteries as session variables
    $_SESSION['H_id'] = $_POST['H_id'];
    $_SESSION['is_team']=$_POST['is_team'];
    $_SESSION['RName'] = $_POST['name'];
    $_SESSION['RPhone'] = $_POST['ph-num'];
    $_SESSION['REmail'] = $_POST['email'];
    $_SESSION['RSchool'] = $_POST['school-name'];
    $_SESSION['is_admin']=$_POST['is_admin'];
    
    
    $_SESSION['Rusername'] = $_POST['Username'];
    $options = ['cost' => 12];
    $hashedPwd = password_hash($_POST['pwd'], PASSWORD_BCRYPT, $options);
    $_SESSION['password'] = $hashedPwd;

    //generate otp
    $otp_str=str_shuffle("0123456789");
    $_SESSION['otp']=substr($otp_str, 0, 6); //generates around 151,200 values
    $_SESSION['otp_time']=time();  //Store current timestamp
    
    $query1 = "SELECT * FROM registration_data WHERE REmail=:Email";
    $stmt1=$pdo->prepare($query1);
    $stmt1->bindParam(":Email",$_SESSION['REmail']);
    $stmt1->execute();
    $count1=$stmt1->rowCount();

    $query2 = "SELECT * FROM login WHERE username=:username";
    $stmt2=$pdo->prepare($query2);
    $stmt2->bindParam(":username",$_SESSION['Rusername']);
    $stmt2->execute();
    $count2=$stmt2->rowCount();

    if ($count1 > 0) {
        $_SESSION['errors_signup'] = "Email already registered. Log In or SignUp with a different email.";; 
        header("Location: signup.php?H=".$_SESSION['H_id'] ."&T=". $_SESSION['is_team']);
  

    } 
    else if ($count2 > 0) {
        $_SESSION['errors_signup'] = "Username already exists. Use a different username";; 
        header("Location: signup.php?H=".$_SESSION['H_id'] ."&T=". $_SESSION['is_team']);
    } 
    else {
        //sendin the mail
        $mail=new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host='SMTP.gmail.com';
        $mail->SMTPAuth=true;
        $mail->Username='ksyeda2003@gmail.com'; // Your gmail
        $mail->Password='qmkainjucuqjymka'; // Your gmail app password 
        $mail->SMTPSecure='tls';
        $mail->Port=587;
        $mail->setFrom('ksyeda2003@gmail.com'); // Your gmail
        $mail->addAddress($_POST["email"]);
        $mail->isHTML(true);
        $mail->Subject="[CODE BATTLE] VERIFY ACCOUNT";

        $message=
        ' <p> Dear ' .$_SESSION['RName'].'<br>To verify your email address, enter this OTP when prompted: <b>' .$_SESSION['otp'].'</b>.</p><p>Regards,<br> CodeBattle</p>';
        $mail->Body=$message;
        
        if ($mail->Send()) {
            header("Location:enter_otp.php");
        }
        else{
            echo $mail->ErrorInfo;
            session_unset();
        }
    }
}

function check_signup_errors() {
if (isset($_SESSION['errors_signup'])) {
    $errors = $_SESSION['errors_signup'];
    echo '<p style="text-align: center; color: #F73634;">' . $errors . '</p>';}
    session_unset();
}

function validate_password($password) {
    // Check if password meets the policy
    if (strlen($password) < 8) {
        return "Password must be at least 8 characters long.";
    }
    if (!preg_match("/[a-z]/", $password)) {
        return "Password must include at least one lowercase letter.";
    }
    if (!preg_match("/[A-Z]/", $password)) {
        return "Password must include at least one uppercase letter.";
    }
    if (!preg_match("/\d/", $password)) {
        return "Password must include at least one number.";
    }
    return null; // Password is valid
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['pwd'];
    $error_message = validate_password($password);
    
    if ($error_message) {
        echo "<p style='color: red;'>$error_message</p>";
        
    }
}