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
    if ($_SESSION['new_TM']!=1 && $_SESSION['new_TM']!=2){
        header("Location: ../events/registered_events.php");
        exit();
    }

    if ($_SESSION['new_TM'] == 2) {
        //existing member data
        $query = "SELECT * FROM solo_data WHERE P_id=:P_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":P_id", $_GET['S']);
        $stmt->execute();
        $memberData = $stmt->fetch();
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
       .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #f44134;
    padding: 8px 20px;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1;
}

.header-left {
    display: flex;
    align-items: center;
}

.logo {
    height: 40px;
    margin-right: 20px;
}

.nav {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.nav li {
    display: inline;
    margin: 0 15px;
}

.nav li a {
    color: white;
    text-decoration: none;
    font-size: 16px;
}

.nav li a:hover {
    text-decoration: underline;
}

.header-right {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;

}

.profile-icon {
    height: 40px;
    cursor: pointer;
    padding-right: 30px;
}

.show {
    display: block;
}
.dropdown-container {
    position: relative;
    display: inline-block;
}
.dropbtn {
    background-color: #F73634;
    color: white;
    border: none;
    padding: 10px;
    font-size: 16px;
    cursor: pointer;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.dropdown-container:hover .dropdown-content {
    display: block;
}
    </style>
</head>
<body>
    <header>
        <div class="header">
            <div class="header-left">
                <img src="https://github.com/N0ZA/code-battle/blob/main/Images/Logo.png?raw=true" alt="Logo" class="logo">
                <ul class="nav">
                    <li><a href="../events/registered_events.php">Registered Events</a></li> 
                </ul>
            </div>
            <div class="header-right">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
                    <div class="dropdown-container">
                        <button class="dropbtn"><i class="fas fa-user"></i>&#x25BC;</button>
                        <div id="profile-dropdown" class="dropdown-content">
                            <a onclick="window.location.href='logout.php';">Logout</a>
                        </div>
                    </div>
                <!--<img src="images/profile-icon.png" alt="Profile" class="profile-icon" onclick="toggleDropdown()">
                <div id="profile-dropdown" class="dropdown-content">
                    <a href="#">Logout</a> 
                </div>-->
            </div>
        </div>
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
                                $result1['TMembers']=NULL;
                            }
                            else if ($_SESSION['is_team'] == 1){
                                $TName = $_SESSION['TName'];
                                if ($_SESSION['new_TM']!=2){
                                    $query1 = "SELECT * FROM team_data WHERE TName=:TName and H_id=:H_id";
                                    $stmt1 = $pdo->prepare($query1);
                                    $stmt1->bindParam(":TName", $TName);
                                    $stmt1->bindParam(":H_id",$_SESSION['H_id']);
                                    $stmt1->execute();
                                    $result1 = $stmt1->fetch();
                                    $result1['TMembers']++;
                                }
                            }   
                        ?>
                        <?php if ($_SESSION['new_TM'] == 2):?>
                            <h2>Edit Member Details For <font color="#F73634"> <?php echo $result2['HName']; ?> </font></h2>
                        <?php else: ?>
                            <h2>Enter Member <?php echo $result1['TMembers'];?> Details For <font color="#F73634"> <?php echo $result2['HName']; ?> </font></h2>
                        <?php endif ?>
                        <div class="form-group">
                            <label for="Name">Name</label>
                            <?php if ($_SESSION['new_TM'] == 2):?>
                                <input type="text" id="name" name="name" class="form-control" value="<?php echo $memberData['PName']?>" required>
                            <?php else:?>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required> <?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <?php if ($_SESSION['new_TM'] == 2):?>
                                <input type="email" id="email" name="email" class="form-control"  value="<?php echo $memberData['PEmail']?>" required>
                            <?php else:?>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required><?php endif; ?>
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
                        $schools=[];
                        $query="SELECT * FROM school_data";
                        $stmt=$pdo->prepare($query);
                        $stmt->execute();
                        $schools=$stmt->fetchAll();
                    ?>
                    <?php if ($_SESSION['is_team'] == 0): ?>
                        <div class="form-group">
                            <label for="school">School</label>
                                <select class="form-control" name="school" id="school" required>
                                    <option value="" disabled selected>Select your School Name</option>
                                <?php foreach ($schools as $school): ?>
                                    <?php if ($_SESSION['new_TM'] == 2):?>
                                        <option value="<?php echo $school['ScName']?>" <?php if ($school['ScName']==$memberData['PSchool']):?> selected <?php endif; ?>><?php echo $school['ScName']?></option>
                                    <?php else:?>
                                        <option value="<?php echo $school['ScName'] ?>"><?php echo $school['ScName']?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <?php $CName =($memberData['C_id']==1)?'Jr_Cadet' : (($memberData['C_id']==2)?'Jr_Captain' : (($memberData['C_id']==3)?'Jr_Colonel' : 'Unknown')); ?>
                            <label for="category">Category</label>
                            <div class="category-container">
                                <div class="form-check">
                                    <?php if ($_SESSION['new_TM'] == 2):?>
                                        <input type="radio" id="cadet" name="category" class="form-check-input" value="1" <?php if ($jrCadet==0) echo 'disabled'; ?> 
                                        <?php if ($CName=='Jr_Cadet') echo 'checked'; ?> required>       
                                    <?php else:?>
                                        <input type="radio" id="cadet" name="category" class="form-check-input" value="1" <?php if ($jrCadet==0) echo 'disabled'; ?> required>
                                    <?php endif; ?>    
                                        <label for="cadet" class="form-check-label">Jr Cadet</label>
                                </div>
                                <!--<span>Available seats: <?php echo $jrCadet; ?></span> -->
                            </div>
                            <div class="category-container">
                                <div class="form-check">
                                <?php if ($_SESSION['new_TM'] == 2):?> 
                                    <input type="radio" id="captain" name="category" class="form-check-input" value="2" <?php if ($jrCaptain == 0) echo 'disabled'; ?> 
                                    <?php if ($CName=='Jr_Captain') echo 'checked'; ?> required>
                                <?php else:?> 
                                    <input type="radio" id="captain" name="category" class="form-check-input" value="2" <?php if ($jrCaptain == 0) echo 'disabled'; ?> required>
                                <?php endif; ?>
                                    <label for="captain" class="form-check-label">Jr Captain</label>
                                </div>
                                <!--<span>Available seats: <?php echo $jrCaptain; ?></span> -->
                            </div>
                            <div class="category-container">
                                <div class="form-check">
                                <?php if ($_SESSION['new_TM'] == 2):?>
                                    <input type="radio" id="colonel" name="category" class="form-check-input" value="3" <?php if ($jrColonel == 0) echo 'disabled'; ?> 
                                    <?php if ($CName=='Jr_Colonel') echo 'checked'; ?> required>
                                <?php else:?>
                                    <input type="radio" id="colonel" name="category" class="form-check-input" value="3" <?php if ($jrColonel == 0) echo 'disabled'; ?> required>
                                <?php endif; ?>
                                    <label for="colonel" class="form-check-label">Jr Colonel</label>
                                </div>
                                <!--<span>Available seats: <?php echo $jrColonel; ?></span> -->
                            </div>
                        </div>
                        <?php
                            check_mem_errors();
                        ?>
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
                            
                            check_mem_errors();
                            
                            if ($result3[$CName]==1 || $result3['TMembers'] + 1 == $result3['MaxP'] || $_SESSION['new_TM'] == 2) {
                                echo '<button class="form-button" type="submit" name="Done">Done</button>';
                            } 
                            else if ($result3['TMembers']==0) {
                                echo '<button class="form-button" type="submit" name="Add_Member">Add Member</button>';
                            }
                            else{
                                echo '<button class="form-button" type="submit" name="Add_Member">Add Member</button>';
                                echo '<button class="form-button" type="submit" name="Done">Done</button> ';
                            }
                    endif; ?>
                  <input type="hidden" name="solo_Id" value="<?php echo isset($_GET['S']) ? $_GET['S'] : ''; ?>">  
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
