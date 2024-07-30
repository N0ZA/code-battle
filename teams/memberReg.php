<?php
    require_once '../includes/dbh.inc.php';
    require_once 'accept_member_data.php';

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
        header("Location: ../index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Registration</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    html, body {
    height: 100%;
    margin: 0;
}
       body {
    background: url(https://github.com/N0ZA/code-battle/blob/main/Images/grids.jpeg?raw=true) no-repeat center center fixed;
    background-size: cover;
    color: #272727;
    display: grid;
    grid-template-rows: auto 1fr auto;
}

    header {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
}
main {
    display: grid;
    place-items: center;
    padding-top: 70px;
    padding-bottom: 60px;
}
        .navbar {
    background-color: #F73634;
    position: fixed; 
    top: 0;
    width: 100%;
    z-index: 1000; 
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
            margin:  auto;
            margin-top: 10px;
            margin-bottom:30px;
            position: relative;
            
        }
        label {
            font-weight: 600;
            font-size: 20px;
        }
        .form-control, .form-check-input {
            color: black ;
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
        .button-container {
            background-color: #F73634;
            border: none;
            border-radius: 25px;
            color: #ffffff;
           
            padding: 0.5rem;
            width: 100%;


        }
        button {
            background-color: #F73634;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: large;
            padding: 5px 30px;
            border-radius: 18px;
            
        }
        button:hover {
            background-color: #000000;
            color: #ffffff;
        }
        
        footer {
    background-color: #000000;
    color: #ffffff;
    padding: 5px;
    text-align: center;
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
        .form-button{
            background-color: #F73634;
            border: none;
            border-radius: 25px;
            color: #ffffff;
            font-size: 1rem;
            padding: 0.5rem;
            width: 100%;
            margin-top: 10px;
        }
        h2 {
            text-align: center;
        }

    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="#"><img src="https://github.com/N0ZA/code-battle/blob/main/Images/logob.png?raw=true" alt="Code Battle" style="height: 60px;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../events/registered_events.php">View Hackathon</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../events/team_details.php">Edit Teams</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <main>
        <div class="container-fluid container-custom">
            <div class="row flex-grow-1">
                <div class="form-wrapper">
                    <form action="accept_member_data.php" method="POST">
                        <?php
                            $query2="SELECT HName FROM hackathon_data WHERE H_id=:H_id";
                            $stmt2=$pdo->prepare($query2);
                            $stmt2->bindParam(":H_id", $_SESSION['H_id']);
                            $stmt2->execute();
                            $result2=$stmt2->fetch();

                            if ($_SESSION['is_team'] == 0){
                                $result1['TMembers']=1;
                            }
                            else{
                                $TName = $_SESSION['TName'];
                                $query1 = "SELECT * FROM team_data WHERE TName=:TName";
                                $stmt1 = $pdo->prepare($query1);
                                $stmt1->bindParam(":TName", $TName);
                                $stmt1->execute();
                                $result1 = $stmt1->fetch();
                                $result1['TMembers']++;
                            }   
                        ?>
                        <h2>Enter Member <?php echo $result1['TMembers'];?> Details For <font color="#F73634"> <?php echo $result2['HName']; ?> </font></h2>
                        <div class="form-group">
                        <label for="Name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                    <div class="form-group">
                        <label for="school">School</label>
                        <input type="text" id="school" name="school" class="form-control" placeholder="Enter your school name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <?php
                        //$_Session['hackathon'] shud be taken from the dashboard, based on which hackathon user chooses to register;
                        if (isset($_SESSION['H_id'])){
                            $query = "SELECT * FROM hackathon_data WHERE H_id = :H_id";
                            $stmt = $pdo->prepare($query);
                            $stmt->bindParam(":H_id", $_SESSION['H_id']);
                            $stmt->execute();
                            $result = $stmt->fetch();
                            $jrCadet = $result['Jr_Cadet'];
                            $jrCaptain = $result['Jr_Captain'];
                            $jrColonel = $result['Jr_Colonel'];
                            $_SESSION['is_team']=$result["is_team"];
                        }
                    ?>
                    <?php if ($_SESSION['is_team'] == 0): ?>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <div class="category-container">
                                <div class="form-check">
                                    <input type="radio" id="cadet" name="category" class="form-check-input" value="1" <?php if ($jrCadet == 0) echo 'disabled'; ?> required>
                                    <label for="cadet" class="form-check-label">Cadet</label>
                                </div>
                                <span>Available seats: <?php echo $jrCadet; ?></span>
                            </div>
                            <div class="category-container">
                                <div class="form-check">
                                    <input type="radio" id="captain" name="category" class="form-check-input" value="2" <?php if ($jrCaptain == 0) echo 'disabled'; ?> required>
                                    <label for="captain" class="form-check-label">Captain</label>
                                </div>
                                <span>Available seats: <?php echo $jrCaptain; ?></span>
                            </div>
                            <div class="category-container">
                                <div class="form-check">
                                    <input type="radio" id="colonel" name="category" class="form-check-input" value="3" <?php if ($jrColonel == 0) echo 'disabled'; ?> required>
                                    <label for="colonel" class="form-check-label">Colonel</label>
                                </div>
                                <span>Available seats: <?php echo $jrColonel; ?></span>
                            </div>
                        </div>
                        <button class="form-button" type="submit" name="Done">Done</button>    
                    <?php else: ?>
                        <?php
                            $query3='SELECT T.TMembers,T.C_id, H.MaxP, H.Jr_Cadet, H.Jr_Captain, H.Jr_Colonel FROM team_data T
                            JOIN hackathon_data H ON T.H_id = H.H_id
                            WHERE T.TName=:TName AND H.H_id=:H_id';
                            
                            $stmt3 = $pdo->prepare($query3);
                            $stmt3->bindParam(":TName", $TName);
                            $stmt3->bindParam(":H_id", $_SESSION['H_id']);  
                            $stmt3->execute();
                            $result3=$stmt3->fetch();
                            $C_id=$result3['C_id'];
                            $CName = ($C_id == 1) ? 'Jr_Cadet' : (($C_id == 2) ? 'Jr_Captain' : (($C_id == 3) ? 'Jr_Colonel' : 'Unknown'));

             
                            if ($result3[$CName]==1 || $result3['TMembers'] + 1 == $result3['MaxP']) {
                                echo '<button class="form-button" type="submit" name="Done">Done</button>';
                            } 
                            else{
                                echo '<button class="form-button" type="submit" name="Add_Member">Add Member</button>';
                                echo '<button class="form-button" type="submit" name="Done">Done</button> ';
                            }
                    endif; ?>
                    <br></br>
                    <?php
                         check_mem_errors();    
                    ?>
                  <input type="hidden" name="source" value="<?php echo isset($_GET['source']) ? $_GET['source'] : ''; ?>">
                </form>
            </div>
        </div>
    </main>
    <footer>
        <p>Code Battle © 2024. All rights reserved. Made with <span class="heart">❤</span> in U.A.E</p>
        <p>Contact us at: info@codebattle.com</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        window.addEventListener('load', function() {
    const preloader = document.querySelector('.preloader');
    preloader.style.display = 'none';
    const content = document.querySelector('.content');
    content.classList.add('loaded');
    content.style.opacity = 1; 
});

        function toggleActive(link) {
            link.classList.toggle('active');
        }
    </script>
</body>
</html>
