<?php
    require_once '../includes/dbh.inc.php';
    require_once 'accept_team_data.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
        header("Location: ../index.php");
        exit();
    }
    if(isset($_SESSION['T_CREATED'])){
        //header("Location: memberRegistration.php");
        //die();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Registeration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: url(https://github.com/N0ZA/code-battle/blob/main/Images/grids.jpeg?raw=true) no-repeat center center fixed;
            background-size: cover;
            color: #272727;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #F73634;
        }
        .nav-link {
            color: #ffffff !important;
            font-size: 16px;
        }
        .nav-link:hover {
            color: #ffcccc !important;
        }
        .form-column {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px;
        }

        form {
            background-color: #FAFAFA;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
            box-sizing: content-box;

        }

        .form-wrapper {
            max-width: 500px;
            width: 100%;
            margin: auto ;
            position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
        }

        label {
            font-weight: 600;
            font-size: 20px;
        }
        .form-control, .form-check-input {

            color: #ffffff;
            border: 1px solid #555555;
            font-size: 1rem;
            padding: 0.5rem 1rem; 
            border-radius: 25px; 
            margin-bottom: 1rem;
            width: 100%;
        }
        .form-control::placeholder {
            color: #aaaaaa;
        }
        .form-check-label {
            font-weight: 300;
            font-size: 16px;
        }
        .category-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            margin-bottom: 5px;

        }
        
        .submit-button {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }
        
        .btn-dark-red {
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
        .btn-dark-red:hover {
            background-color: #000000;
            color: #ffffff;
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
        .form-check-input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
        }
        .form-check-label {
            position: relative;
            padding-left: 35px;
            cursor: pointer;
        }
        .form-check-label::before {
            content: "";
            position: absolute;
            margin-top: 4px;
            left: 0;
            height: 18px;
            width: 18px;
            background-color: #333333;
            border-radius: 50%;
            border: 1px solid #555555;
        }
        .form-check-input:checked ~ .form-check-label::before {
            background-color: #F73634;
            border-color: #F73634;
        }
        .form-check-label::after {
            content: "";
            position: absolute;
            margin-top: 4px;
            top: 4px;
            left: 4px;
            height: 10px;
            width: 10px;
            background-color: #ffffff;
            border-radius: 50%;
            opacity: 0;
            transition: opacity 0.2s;
        }
        .form-check-input:checked ~ .form-check-label::after {
            opacity: 1;
        }
        .disabled {
            color: #cecece;
            font-weight: 400;
        }
        .enabled {
            font-weight: 400;
        }
        .available-seats-disabled {
            color: #cecece;
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
    .button-container {
            text-align: center;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            background-color: #F73634;
            padding: 15px;
            margin: auto;
        }
        button {
            background-color: #F73634;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: large;
            padding: 5px 30px;
            margin-left: 1em;
            border-radius: 18px;
            font-weight: bold;
        }
        header {
  position: relative;
  z-index: 1000;
}
    </style>

</head>
<body>
<div class="preloader">
  <div class="loader"></div>
</div>  
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="#"><img src="https://github.com/N0ZA/code-battle/blob/main/Images/logob.png?raw=true" alt="Code Battle" style="height: 60px;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">View Hackathon</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Edit Teams</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <div class="container-fluid container-custom">
        <div class="row flex-grow-1">
            <div class="form-wrapper">
                <form action="accept_team_data.php" method="POST">
                    <h2>Enter <font color="#F73634">Team Details</font></h2>
                    <div class="form-header text-center mb-4"></div>
                    <div class="form-body">
                        <div class="form-group">
                            <label for="teamName">Team Name</label>
                            <input type="text" id="teamName" name="teamName" class="form-control" placeholder="Enter team name" required>
                        </div>
                        <div class="form-group">
                            <label for="noMembers">Number of Members</label>
                            <input type="number" id="noMembers" name="noMembers" class="form-control" placeholder="Enter number of members" required>
                        </div>
                        <?php
                            //$_Session['hackathon'] shud be taken from the dashboard, based on which hackathon user chooses to register;
                            if (isset($_SESSION['H_id'])){
                                $query="SELECT * from hackathon_data where H_id=:H_id";
                                $stmt=$pdo->prepare($query);
                                $stmt->bindParam(":H_id", $_SESSION['H_id']);
                                $stmt->execute();
                                $result=$stmt->fetch();
                                $jrCadet=$result['Jr_Cadet'];
                                $jrCaptain=$result['Jr_Captain'];
                                $jrColonel=$result['Jr_Colonel'];
                                $maxP=$result['MaxP'];
                            }
                            ?>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <div class="category-container">
                                <div class="form-check">
                                    <input type="radio" id="cadet" name="category" class="form-check-input"  value="1" <?php if ($jrCadet == 0) echo 'disabled'; ?> required>
                                    <label for="cadet" class="form-check-label">Cadet</label>
                                </div>
                                <span>Available seats: <?php echo $jrCadet; ?> </span>
                            </div>
                            <div class="category-container">
                                <div class="form-check">
                                    <input type="radio" id="captain" name="category" class="form-check-input"  value="2" <?php if ($jrCaptain == 0) echo 'disabled'; ?> required>
                                    <label for="captain" class="form-check-label">Captain</label>
                                </div>
                                <span>Available seats: <?php echo $jrCaptain; ?> </span>
                            </div>
                            <div class="category-container">
                                <div class="form-check">
                                    <input type="radio" id="colonel" name="category" class="form-check-input" value="3" <?php if ($jrColonel == 0) echo 'disabled'; ?> required>
                                    <label for="colonel" class="form-check-label">Colonel</label>
                                </div>
                                <span>Available seats:  <?php echo $jrColonel; ?> </span>
                            </div>
                        </div>
                        <input type="hidden" name="jrCadet" value="<?php echo $jrCadet; ?>">
                        <input type="hidden" name="jrCaptain" value="<?php echo $jrCaptain; ?>">
                        <input type="hidden" name="jrColonel" value="<?php echo $jrColonel  ; ?>">
                        <input type="hidden" name="maxP" value="<?php echo $maxP; ?>">
                        <?php
                            check_team_errors();    
                        ?>
                        <div class="submit-button">
                            <button type="submit" class="btn btn-dark-red">Next</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer>
        <p>Code Battle &copy; 2024. All rights reserved. Made with ❤️ in U.A.E</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
      function load(){
        const preloader = document.querySelector('.preloader');
        preloader.style.display = 'none';
      }

      window.addEventListener('load', load);
    </script>

</body>
</html>
