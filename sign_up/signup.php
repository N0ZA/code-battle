<?php
    require_once "send_mail.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['Reg_CREATED'])){
        header("Location: ../index.php");
        die();
    }
    if ($_SERVER["REQUEST_METHOD"]=="GET"){
      if (isset($_GET['H']) || isset($_GET['T'])){
          $H_id=$_GET['H'];
          $is_team=$_GET['T'];
          if ($H_id==NULL || $is_team==NULL){     //if only one of them is set then direct to error
              header('Location: ../error404.html');
              exit();
          }
          $query='SELECT * FROM hackathon_data WHERE H_id=:H_id AND is_team=:is_team';
          $stmt = $pdo->prepare($query);
          $stmt->bindParam(":H_id",$H_id);
          $stmt->bindParam(":is_team",$is_team);
          $stmt->execute();
          $result=$stmt->fetch();  
          //if user makes any changes with hid or isteam in URL tht is invalid then it goes to error page 
          if ($result['H_id']!=$H_id || $result['is_team']!=$is_team){
              header('Location: ../error404.html');
              exit();
          }
      }
    } 
    $schools=[];
    $query="SELECT * FROM school_data";
    $stmt=$pdo->prepare($query);
    $stmt->execute();
    $schools=$stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
      background-image: url(https://github.com/N0ZA/code-battle/blob/main/Images/grids.jpeg?raw=true);
      background-size: cover;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      margin: 0;
    }
    .form-container {
      font-weight: 500;
      max-width: 500px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      width: 50%;
      max-width: 700px;
      margin: 20px auto;
      background-color: #FAFAFA;
      border-radius: 20px;
      padding: 2rem;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
      box-sizing: content-box;
      
    }
    footer {
      background-color: #000000;
      color: #ffffff;
      padding: 5px;
      text-align: center;
    }
    .button-container {
      background-color: #F73634;
      padding: 5px;
    }
    .img {
      margin: 5px;
    }
    .btn-primary {
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

  .btn-primary:hover {
            background-color: #000000;
            color: #ffffff;
        }

    label {
      font-weight: 600;
      font-size: 20px;
    }
    .btn-group-toggle {
      position: relative;
      width: 50%;
      left: 50%;
      transform: translateX(-50%);
      text-align: center;
      margin-bottom: 3rem;
    }
    .btn-group-toggle .btn-secondary {
    background-color: #F73634;
    color: #ffffff;
    border: none;
  }

  .btn-group-toggle .btn-secondary.active {
    background-color: #ff0000;
  }
    .form-control, .form-check-input {
      border-radius: 20px;
      border: 1px solid #555555;
    } .preloader {
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
       header {
  position: relative;
  z-index: 1000;
}

.navbar-toggler span {
  color: #ffffff;
}
  </style>
  <title>CodeBattle - Sign up</title>
</head>
<body>
<div class="preloader">
  <div class="loader"></div>
</div>
<header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="#"><img src="https://github.com/N0ZA/code-battle/blob/main/Images/Logo.png?raw=true" alt="Code Battle" style="height: 60px;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span><i class="fas fa-user"></i>&#x25BC;</span>      
            </button>
        </nav>
    </header>
  <div class="form-container">
    <div class="form-group" id="rtype">
      <div class="btn-group btn-group-toggle justify-content-center" data-toggle="buttons">
        <label class="btn btn-secondary active">
          <input type="radio" name="rtype" value="parent" checked onchange="toggleForm(this)"> Parent
        </label>
        <label class="btn btn-secondary">
          <input type="radio" name="rtype" value="teacher" onchange="toggleForm(this)"> Teacher
        </label>
        <label class="btn btn-secondary">
          <input type="radio" name="rtype" value="student" onchange="toggleForm(this)"> Student
        </label>
      </div>
      <div id="parent">
        <form action="send_mail.php" method="POST" class="createParentForm">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
          </div>
          <div class="form-group">
          </div>
          <div class="form-group">
            <label for="ph-num">Contact Number:</label>
            <input type="text" class="form-control" id="ph-num" name="ph-num" pattern="^\d{3}-\d{7}$" placeholder="Enter your contact number (050-1234567)" required>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
          </div>
          <div class="form-group">
            <label for="school">School:</label>
            <select class="form-control" id="school-name" name="school-name" required>
              <option value="" disabled selected>Select your School Name</option>
            <?php foreach ($schools as $school): ?>
              <option value="<?php echo $school['ScName'] ?>"><?php echo $school['ScName']?></option>
            <?php endforeach; ?>
            </select>
          </div>  
          <div class="form-group">
            <label for="Username">Username:</label>
            <input type="text" class="form-control" id="Username" name="Username" placeholder="Choose a username" required>
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Choose a password" required pattern="(?=.\d)(?=.[a-z])(?=.*[A-Z]).{8,}" title="Password must be at least 8 characters long, contain at least one number, one uppercase letter, and one lowercase letter">
          </div>
          <?php
              check_signup_errors();
          ?>
          <input type="hidden" name="is_admin" value="2">  
          <input type="hidden" name="H_id" value="<?php echo $H_id;?>">  
          <input type="hidden" name="is_team" value="<?php echo $is_team; ?>">  
          <button type="submit" class="btn btn-primary" name="SignUp">Submit</button><br></br>
          <p  style="font-size:large; text-align: center; color: red;">Already have an account? <a href="../index.php?H=<?php echo $H_id;?>&T=<?php echo $is_team;?>">Log In</a></p>
        </form>
      </div>
      <div id="teacher" style="display:none">
        <form action="send_mail.php" method="POST" class="createTeacherForm">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
          </div>
          <div class="form-group">
            <label for="ph-num">Contact Number:</label>
            <input type="text" class="form-control" id="ph-num" name="ph-num" pattern="^\d{3}-\d{7}$" placeholder="Enter your contact number (050-1234567)" required>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
          </div>
          <div class="form-group">
            <label for="school">School:</label>
            <select class="form-control" id="school-name" name="school-name" required>
              <option value="" disabled selected>Select your School Name</option>
            <?php foreach ($schools as $school): ?>
              <option value="<?php echo $school['ScName'] ?>"><?php echo $school['ScName']?></option>
            <?php endforeach; ?>
            </select>
          </div>  
          <div class="form-group">
            <label for="Username">Username:</label>
            <input type="text" class="form-control" id="Username" name="Username" placeholder="Choose a username" required>
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Choose a password" required pattern="(?=.\d)(?=.[a-z])(?=.*[A-Z]).{8,}" title="Password must be at least 8 characters long, contain at least one number, one uppercase letter, and one lowercase letter">
          </div>
          <?php
              check_signup_errors();
          ?>
          <input type="hidden" name="is_admin" value="3">
          <input type="hidden" name="H_id" value="<?php echo $H_id;?>">  
          <input type="hidden" name="is_team" value="<?php echo $is_team; ?>">  
          <button type="submit" class="btn btn-primary" name="SignUp">Submit</button><br></br>
          <p  style="font-size:large; text-align: center; color: red;">Already have an account? <a href="../index.php?H=<?php echo $H_id;?>&T=<?php echo $is_team;?>">Log In</a>
        </form>
      </div>
      <div id="student" style="display:none">
        <form action="send_mail.php" method="POST" class="createStudentForm">
          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
          </div>
          <div class="form-group">
            <label for="ph-num">Contact Number:</label>
            <input type="text" class="form-control" id="ph-num" name="ph-num" pattern="^\d{3}-\d{7}$" placeholder="Enter your contact number (050-1234567)" required>
          </div>
          <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
          </div>
          <div class="form-group">
            <label for="school">School:</label>
            <select class="form-control" id="school-name" name="school-name" required>
              <option value="" disabled selected>Select your School Name</option>
            <?php foreach ($schools as $school): ?>
              <option value="<?php echo $school['ScName'] ?>"><?php echo $school['ScName']?></option>
            <?php endforeach; ?>
            </select>
          </div>  
         <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="Username" name="Username" placeholder="Choose a username" required>
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Choose a password" required pattern="(?=.\d)(?=.[a-z])(?=.*[A-Z]).{8,}" title="Password must be at least 8 characters long, contain at least one number, one uppercase letter, and one lowercase letter">
          </div>
          <?php
              check_signup_errors();
          ?>
          <input type="hidden" name="is_admin" value="4">
          <input type="hidden" name="H_id" value="<?php echo $H_id;?>">  
          <input type="hidden" name="is_team" value="<?php echo $is_team; ?>">  
          <button type="submit" class="btn btn-primary" name="SignUp">Submit</button> <br></br>
          <p  style="font-size:large; text-align: center; color: red;">Already have an account? <a href="../index.php?H=<?php echo $H_id;?>&T=<?php echo $is_team;?>">Log In</a></p>
        </form>
      </div>
    </div>
  </div>
  <footer>
    <p>Code Battle &copy; 2024. All rights reserved. Made with ❤️ in U.A.E</p>
  </footer>
  <script>
    function toggleForm(x) {
      const id = x.value;
      document.getElementById("parent").style.display = id === "parent" ? "block" : "none";
      document.getElementById("teacher").style.display = id === "teacher" ? "block" : "none";
      document.getElementById("student").style.display = id === "student" ? "block" : "none";
    }
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
    <script>
      function load(){
        const preloader = document.querySelector('.preloader');
        preloader.style.display = 'none';
      }

      window.addEventListener('load', load);
    </script>

</html>
