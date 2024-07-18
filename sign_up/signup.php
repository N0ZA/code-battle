<?php
    require_once "send_mail.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (isset($_SESSION['Reg_CREATED'])){
        header("Location: ../index.php");
        die();
    }
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
      background-image: url(https://github.com/N0ZA/code-battle/blob/main/images/grids.jpeg?raw=true);
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
    }
  </style>
  <title>CodeBattle - Sign up</title>
</head>
<body>
  <div class="button-container">
    <img src="C:\Users\moham_jvk4ynn\Downloads\Logo.png" alt="CodeBattle Logo" class="img-fluid" style="max-width: 150px; margin-right: 10px;">
    <div class="profile-dropdown"></div>
  </div>
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
            <label for="Username">Username:</label>
            <input type="text" class="form-control" id="Username" name="Username" placeholder="Choose a username" required>
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Choose a password" required>
          </div>
          <?php
              check_signup_errors();
          ?>
          <input type="hidden" name="is_admin" value="2">  
          <button type="submit" class="btn btn-primary" name="SignUp">Submit</button><br></br>
          <p  style="font-size:large; text-align: center; color: red;">Already have an account? <a href="../index.php">Log In</a></p>
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
            <label for="school-name">School Name:</label>
            <input type="text" class="form-control" id="school-name" name="school-name" placeholder="Enter your school name" required>
          </div>
          <div class="form-group">
            <label for="Username">Username:</label>
            <input type="text" class="form-control" id="Username" name="Username" placeholder="Choose a username" required>
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Choose a password" required>
          </div>
          <?php
              check_signup_errors();
          ?>
          <input type="hidden" name="is_admin" value="3">
          <button type="submit" class="btn btn-primary" name="SignUp">Submit</button><br></br>
          <p  style="font-size:large; text-align: center; color: red;">Already have an account? <a href="../index.php">Log In</a></p>
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
            <label for="school-name">School Name:</label>
            <input type="text" class="form-control" id="school-name" name="school-name" placeholder="Enter your school name" required>
          </div>
          <div class="form-group">
            <label for="class">Class/Grade:</label>
            <input type="number" class="form-control" id="class" name="class" min="1" max="13" placeholder="Enter your grade" required>
          </div>
          <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="Username" name="Username" placeholder="Choose a username" required>
          </div>
          <div class="form-group">
            <label for="pwd">Password:</label>
            <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Choose a password" required>
          </div>
          <?php
              check_signup_errors();
          ?>
          <input type="hidden" name="is_admin" value="4">
          <button type="submit" class="btn btn-primary" name="SignUp">Submit</button> <br></br>
          <p  style="font-size:large; text-align: center; color: red;">Already have an account? <a href="../index.php">Log In</a></p>
        </form>
      </div>
    </div>
  </div>
  <footer>
    <p>Code Battle &copy; 2024. All rights reserved. Made in U.A.E</p>
    <p>Contact us at: info@codebattle.com</p>
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
</html>
