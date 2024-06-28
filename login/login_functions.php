<?php

declare(strict_types=1);

function is_input_empty(string $username,string $pwd){
    if (empty($username)||empty($pwd)){
        return true;
    }
    else {
        return false;
    }
}


function get_userdata(object $pdo,string $username){
    $query="SELECT* from login where username= :username;";
    $stmt=$pdo->prepare($query);
    $stmt->bindParam(":username",$username);
    $stmt->execute();

    //grabbing one data 
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    return $result;

    //if there is a row it returns an array result if no value it returns 0 false
}


//pdo is db objec
function is_username_wrong($result){
    //if result is false
    if ($result==0){
        //username not found in db
        return true;
    }
    else{
        return false;
    }    
}

function is_password_wrong(string $pwd,string $storedPwd){
    //if passwords donot match 
   
    if (!password_verify($pwd,$storedPwd) ){
        //username not found in db
        return true;
    }
    else{
        return false;
    }    
}

function check_login_errors(){
    if(isset($_SESSION["errors_login"])){
        $errors=$_SESSION["errors_login"];

        echo "<br>";

        foreach($errors as $error){
            echo '<h2 style="color: #F73634;">';
                echo $error;
            '</h2>';
        }

        unset($_SESSION["errors_login"]);
    }
    else if(isset($_GET["login"])&&$_GET["login"]==="success"){
        if($_SESSION["user_isadmin"]==1){

            header("Location: ../admin/admin.php?login=success");
            $pdo=null;
            $stmt=null;

            die();
        }
        else{
            header("Location: ../judge/judge.php?login=success");
            $pdo=null;
            $stmt=null;
            die();

        }
        die();
    }
}


function logout(){
    $_SESSION = array();
    session_unset();
    session_destroy();

    $past = time() - 3600;
    foreach ($_COOKIE as $key => $value) {
        setcookie($key, '', $past, '/');
    }

    header("Location: ../index.php");
    exit(); 
}