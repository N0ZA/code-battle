<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
    header("Location: ../../index.php");
    exit();
}
if(isset($_SESSION['H_created'])){
  header("Location: AddJudge.php");
  die();
}
// if(!isset($_SESSION['H_created'])){
//   header("Location: ../admin.php");
//   die();
// }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Code Battle - Create</title>

    <style>
    
    body {
      width: 100%;
      height: 100vh;
      margin: 0;
      background-color: #E3E3E3;
      background-image: url(../../Images/grids.jpeg);
      
      background-size: cover;
      color: black;
      font-family: Tahoma;
      font-size: 16px;
    }
    
    h1, #instruction{
      margin: 1em auto;
      text-align: center;
      color: black;	
    }

    h1{
      margin-bottom: 0;
    }

    #instruction{
      font-size: large;
      padding-top: 1em;
    }
    
    .createForm {
      width: 60vw;
      max-width: 500px;
      min-width: 300px;
      margin: 1rem auto;
      background-color: white;	
      border-radius: 25px;
      border: 1px solid;
      padding: 0 3rem 3rem 3rem ;
    }
    
    input,
    select {
      display: block;
      margin: 10px 0 0 0;
      width: 100%;
      min-height: 2em;
    }
    
    input{
      background-color: white;
      border: 0.5px solid black;
      color: #272727;
      border-radius: 25px ;
    }

    .team-type{
      display: flex;
      align-items: center;
      margin-top: 1em;
    }

    input[type="time"], input[type="date"] {
      display: inline;
      width:25%;
      padding-left: 2rem;
      margin:1rem;
    }
    input[type="checkbox"]{
      display: flex;
      width: 10%;
    }
    ::placeholder{
      color: #272727;
    }

    .button-container {
        text-align: center;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        background-color: #F73634;
        padding: 15px;
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

    button:hover{
      text-decoration: underline;
    }

    .score-dropdown {
      margin-left: 40px;
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }

    .score-dropdown a {
        font-family: 'Arial', sans-serif;
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    .score-dropdown a:hover {
        background-color: #ddd;
    }
    .scoreboard-dropdown-container:hover .score-dropdown {
        display: block;
    }

    #profile-dropdown{
      margin-left: 10px;
    }

    #nextButton{
      background-color: black;
      border: 1px;
      border-radius: 25px;
      color: #ffffff;
      font-size: 1rem;
      padding: 0.5rem;
      width: 100%;
      margin-top: 2rem;
    }

    #nextButton:hover{
        background-color: #F73634;
        color: white;
        text-decoration: none;
    }
    
    footer {
      background-color: #000000;
      color: #ffffff; 
      padding: 5px;
      text-align: center;
      position: sticky;
      top: 100%;
    }

    #MaxP{
      margin-top: 2em;
      display: none;
    }
    h2{
      padding-top: 80px;
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
  </style>

  </head>
  <body>
  <div class="preloader">
  <div class="loader"></div>
</div>

<div class="button-container">
        <button class="navButtons" onClick="window.location.href='../admin.php';">Home</button>
        <button class="navButtons" onClick="window.location.href='../HDetail.php';">View Hackathon</button>
        <button class="navButtons" onClick="window.location.href='../create.php';">Create Hackathon</button>
        <div class="scoreboard-dropdown-container" id ="profile-container">
        <button class="dropbtn"><i class="fas fa-user"></i>&#x25BC;</button>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <div id ="profile-dropdown" class="score-dropdown">
            <a onclick="window.location.href='../../logout.php';">Logout</a>
        </div>
        </div>
    </div>

    <h1>Hackathon <font color = "#F73634">Details</font></h1>
    <h2 id = "instruction">Please fill out the required information</h2>

    <form action="accept_hackathon_data.php" method="POST" class="createForm">
      <br>
      <input id="HName" name="HName" type="text"  placeholder=" Name of the Hackathon" required/>
      <label for="HDate">Date: <input id="HDate" name="HDate" type="date" min="2024-03-01"  required/></label>
      <label for="HTime">Time: <input id="HTime" name="HTime" type="time" required /></label>

      <p>Category:</p>
      <div class="Category" style="display: flex; align-items: center;">

      <label for="jr-cadet" >Jr Cadet</label>
        <input type="checkbox" id="jr-cadet" name="Category[]" value="Jr_Cadet">
        
        <label for="jr-captain" style="margin-left: 2em;">Jr Captain</label>
        <input type="checkbox" id="jr-captain" name="Category[]" value="Jr_Captain">
       
        <label for="jr-colonel" style="margin-left: 2em;">Jr Colonel</label>
        <input type="checkbox" id="jr-colonel" name="Category[]" value="Jr_Colonel">

      </div>

      <p>Team Type:</p>

      <div class = "team-type">

        <label>Team Based</label>
        <input type="radio" name="team-type" value="team" required onclick="team()">
    
        <label>Individual Based</label>
        <input type="radio" name="team-type" value="individual" required onclick="individual()">

      </div>

      <div id = "max-players">
        <input id="MaxP" type="number" name="MaxP" max="5" placeholder=" Maximum participants per team" />
      </div>

      <button type="submit" id="nextButton">Next</button>
    </form>

    <script>

      function team(){
          var container = document.getElementById("MaxP");
          container.style.display = 'flex';
          container.required = true;
      }

      function individual(){
          var container = document.getElementById("MaxP");
          container.style.display = 'none';
          container.required = false;
      }
    </script>

<<script>

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