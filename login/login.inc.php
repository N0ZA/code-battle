<?php

if ($_SERVER["REQUEST_METHOD"]=="POST"){
    $username=$_POST["username"];
    $pwd=$_POST["pwd"];
    
    try{
        require_once '../includes/dbh.inc.php';
        require_once 'login_functions.php';
        // require_once 'login_contr.inc.php';

        //error handling
        $errors=[];

        //function made in contrl
        if(is_input_empty($username,$pwd)){
            $errors["empty_input"]="FILL ALL FIELDS";
        }
        else{

            $result = get_userdata($pdo,$username);
            
            if(is_username_wrong($result)){
                $errors["login_incorrect"]="Incorrect login info";
            }
            
            if(!is_username_wrong($result) && is_password_wrong($pwd,$result["pwd"])){
                $errors["login_incorrect"]="Incorrect login info";
            }
        }
        
        require_once '../includes/config_session.inc.php';

        if ($errors){
            $_SESSION["errors_login"]=$errors;
            header("Location: ../index.php");
            die();
        }

        else{
            $newSessionId=session_create_id();
            $sessionId=$newSessionId."_".$result['user_id'];
            session_id($sessionId);

            $_SESSION["user_id"]=$result['user_id'];
            $_SESSION["user_username"]=htmlspecialchars($result['username']);
            $_SESSION["user_isadmin"]=htmlspecialchars($result['admin']);
            
            if($result['admin']==1){

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

    
        }
        

    }catch(PDOException $e){
        die("Query failed: ".$e->getMessage());
    }
}
else{
 header("Location: ../index.php");
    die();
}

