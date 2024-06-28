<?php
    require_once "login/login_functions.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['user_isadmin']) || isset($_SESSION['user_id'])) {
        if($_SESSION["user_isadmin"]==1){
            header("Location: admin/admin.php");
            $pdo=null;
            $stmt=null;

            die();
        }
        else{
            header("Location: judge/judge.php");
            $pdo=null;
            $stmt=null;
            die();

        }
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Battle - Login</title>
    <style>

body {
    font-family: Arial, sans-serif;
    color: black;
    margin: 0;
    padding: 0;
    background-color: #E3E3E3;
    background-image: url(Images/grids.jpeg);
    
    background-size: cover;
    overflow-x: hidden;
    
    
}

 .container {
    display: flex;
    max-width: 500px;
    max-height:600px;
    margin: 1rem auto;
    background-color: #FAFAFA;
    color: white;
    border-radius: 25px;
    padding: 3rem; 
    box-sizing: border-box; 
    box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.5);
    /*margin-top:9rem;*/
}

        .form-container {
            display: flex;
            flex-direction: column;
            align-items: left;
            justify-content: center;
            padding: 20px;
            border-radius: 30px;
            flex-grow: 1;
            text-align: center;
            /* margin: 5%; */
        }

        .form-container p {
            font-size: 1rem; 
            text-align: center;
        }
        
            .form-container h4 {
                padding: 10px;
                text-align:center;
            }

        .form-group {
            margin-bottom: 1.5rem;
            width: 100%;
        }

        .form-group label {
            display: block;
            text-align: left;
        }

        .form-group input {
            border: 1px solid #cccccc;
            border-radius: 35px;
            font-size: 1rem;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
            
        }


        button {
            background-color: #F73634;
            border: none;
            border-radius: 25px;
            color: #ffffff;
            font-size: 1rem;
            padding: 0.5rem;
            width: 100%;
            margin-top: 2rem;
            margin-bottom: 0%;
        }

        button:hover {
            background-color: #000000;
            color: #ffffff;
        }

        img{
            height: 80%;
            margin-top: 0%;
        }

        hr{
            width: 100%;
        }

footer {
    background-color: #000000;
    color: #ffffff; 
    padding: 5px;
    text-align: center;
    position: fixed;
    bottom: 0;
    width: 100%; 
}

        @media screen and (max-width: 768px) {
            .form-container {
                padding: 10px;
            }

            .form-container h1 {
                font-size: 2rem;
            }

            .form-container p {
                font-size: 1rem;
            }

            .form-group {
                width: 100%;
            }

            button,
            .forgot-password,
            hr {
                width: 100%;
            }
        }

        @media screen and (max-width: 700px) {
            .image-container {
                display: none;
            }
            .container {
                flex-direction: column;
            }
        }
    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #272727;
        color:#F73634;
        font-size: x-large;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .loader {
        border: 8px solid #0000007c;
        border-top: 8px solid #F73634;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: spin 2s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .logo {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top:15px;
}

.logo img {
    max-width: 200px; 
    max-height: 200px; 
}
    
    </style>
</head>
<body>
 <div class="preloader">
  <div class="loader"></div>
</div> 

    
    <div class="container">
       

        <div class="form-container">
         
         <div class="logo">
   
                <img src="Images/logob.png" alt="CodeBattle Image" >
           
</div>
              <h1><font color = "Black">Welcome</font> <font color = "#F73634">Back!</font></h1>
            <!--<p>CodeBattle – where young minds transform ideas into digital masterpieces. <br>Join the journey and let your creativity unfold!</p>-->
            <form action="login/login.inc.php" method="POST" class="myform">
                <h4><font color = "Black">Please enter your login details to proceed.</font></h4>
                <div class="form-group">
                    <label for="username"></label>
                    <input type="text" id="username" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="password"></label>
                    <input type="password" id="password" name="pwd" placeholder="Password">
                </div>
                <!--<hr>-->
                <button type="submit">Log In</button>
            </form>
            <?php
                check_login_errors();
            ?>
        </div>
            
    </div>
    
     <script>

function load(){
    const preloader = document.querySelector('.preloader');
    preloader.style.display = 'none';
}

window.addEventListener('load', load);

</script>

    

</body>

<footer>
    <p>Code Battle &copy; 2024. All rights reserved. Made with ❤️ in U.A.E</p>
</footer>

</html>