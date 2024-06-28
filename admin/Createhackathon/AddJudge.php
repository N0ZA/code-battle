<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
    header("Location: ../../index.php");
    exit();
}
//so that a person goes back to the admin page
if(isset($_SESSION['H_judges_added'])){
    header("Location: AddCriteria.php");
    die();
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Battle - Add Judge</title>

    <style>
        body {
            width: 100%;
            min-height: 100vh;
            margin: 0;
            background-color: #E3E3E3;
            background-image: url(../../Images/grids.jpeg);
            
            background-size: cover;
            color: black;
            font-family: Tahoma;
            font-size: 16px;
        }

        #instruction{
            font-size: large;
            text-align: center;
            color: black;
            font-weight: bold;
        }

        h1{
            margin-top: 1em auto;
            text-align: center;
        }

        input,
        select {
            display: block;
            margin: 10px 0 0 0;
            width: 100%;
            min-height: 2em;
        }

        input{
            background-color: #ffffff;
            border: 1px solid;
            color: #272727;
            border-radius: 25px ;
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

        #nextButton, #discardButton {
            background-color: #272727;
            border: 1px;
            border-radius: 25px;
            color: #ffffff;
            font-size: 1rem;
            padding: 0.5rem;
            width: 25%;
            margin-top: 2rem;
            margin-left: 1rem;
        }

        #nextButton:hover, #discardButton:hover{
            background-color: #F73634;
            text-decoration: none;
        }
        

        select{
            width: 25%;
            font-size: medium;
            background-color: #F73634;
            color: white;
            padding: 7px;
            border-radius: 25px;
            margin-left: auto;
            margin-right: auto;
        }

        #text-field-container{
            width: 60vw;
            text-align: center;
            max-width: 500px;
            min-width: 300px;
            margin: 1rem auto;
            border-radius: 25px;
            padding: 0 3rem 3rem 3rem ;
        }

        ::placeholder{
            color: #272727;
        }

        footer {
            background-color: #000000;
            color: #ffffff; 
            padding: 5px;
            text-align: center;
            position: sticky;
            top: 100%;
        }

        @media screen and (max-width: 700px) {

            select{
                width: 25%;
                font-size: 15px;
                padding: 3px;
            }

            h1{
                font-size: x-large;
            }

            #instruction{
                font-size: medium;
            }

            #formid{
                font-size: small;
                width: 30vw;
            }

            h2{
                font-size: medium;   
            }

            footer{
                font-size: small;
            }
        }
    </style>

    <script>

        function discard(){
            const requiredInputs = document.querySelectorAll('form input[required]');

            // Temporarily remove the "required" attribute from each input
            requiredInputs.forEach(function(input) {
            input.removeAttribute('required');
            });
        }


        function generateTextFields() {
            var selectedValue = document.getElementById("judgescount").value;

            var container = document.getElementById("text-field-container");

            container.innerHTML = "";
            var judgeName, judgeEmail, judgeUsername, judgePass;
            var jr_cadet, jr_colonel, jr_captain;
            var nameLabel, emailLabel, userLabel, passLabel, temp;
            var jr_cadetLabel, jr_colonelLabel, jr_captainLabel;
            var heading;

            document.getElementById("text-field-container").style.backgroundColor = "#ffffff";
            document.getElementById("text-field-container").style.border = "1px solid";
            

            container.appendChild(document.createElement("br")); 

            for (var i = 0; i < selectedValue; i++) {

                judgeName = document.createElement("input");
                judgeName.required=true;
                judgeName.type = "text";
                judgeName.placeholder = " Name";
                judgeName.id = "JName_"+(i+1)
                judgeName.name = "JName_"+(i+1)
                container.appendChild(judgeName);

                heading = document.createElement("h2");
                heading.style.color = "black";
                temp = document.createTextNode("Judge "+(i+1)+" Details");
                heading.appendChild(temp);
                document.getElementById("text-field-container").insertBefore(heading,document.getElementById("JName_"+(i+1)));

                container.appendChild(document.createElement("br")); 

                judgeEmail = document.createElement("input");
                judgeEmail.required=true;
                judgeEmail.type = "email";
                judgeEmail.placeholder = " Email";
                judgeEmail.name = "JEmail_"+(i+1)
                container.appendChild(judgeEmail);

                container.appendChild(document.createElement("br")); 

                judgeUsername = document.createElement("input");
                judgeUsername.required=true;
                judgeUsername.type = "text";
                judgeUsername.placeholder = " Username"
                judgeUsername.name = "JUsername_"+(i+1)
                container.appendChild(judgeUsername);

                container.appendChild(document.createElement("br")); 

                judgePass = document.createElement("input");
                judgePass.required=true;
                judgePass.type = "password";
                judgePass.placeholder = " Password";
                judgePass.name = "JPass_"+(i+1)
                container.appendChild(judgePass);

                container.appendChild(document.createElement("br")); 

                //checkbox starts here

                jr_cadet = document.createElement("input");
                
                jr_cadet.type = "checkbox";
                jr_cadet.id = "jrcadet_"+(i+1)
                jr_cadet.name = "Jr_Cadet"+(i+1)

                jr_cadetLabel = document.createElement("label");
                temp = document.createTextNode("Jr Cadet");
                jr_cadetLabel.appendChild(temp);

                jr_captain = document.createElement("input");
                
                jr_captain.type = "checkbox";
                jr_captain.id = "jrcaptain_"+(i+1)
                jr_captain.name = "Jr_Captain"+(i+1)

                jr_captainLabel = document.createElement("label");
                temp = document.createTextNode("Jr Captain");
                jr_captainLabel.appendChild(temp);

                jr_colonel = document.createElement("input");
                
                jr_colonel.type = "checkbox";
                jr_colonel.placeholder = " Name";
                jr_colonel.id = "jrcolonel_"+(i+1)
                jr_colonel.name = "Jr_Colonel"+(i+1)

                jr_colonelLabel = document.createElement("label");
                temp = document.createTextNode("Jr Colonel");
                jr_colonelLabel.appendChild(temp);

                const newdiv = document.createElement('div');
                newdiv.classList.add('checkbox-container');
                newdiv.appendChild(jr_cadetLabel);
                newdiv.appendChild(jr_cadet);

                newdiv.appendChild(jr_captainLabel);
                newdiv.appendChild(jr_captain);

                newdiv.appendChild(jr_colonelLabel);
                newdiv.appendChild(jr_colonel);

                newdiv.style.display = "flex";
                newdiv.style.textAlign="center";

                container.appendChild(newdiv);

                container.appendChild(document.createElement("br")); 

                if (i != selectedValue-1){
                    container.appendChild(document.createElement("hr")); 
                }
            }

            const x = document.createElement("button");
            x.name = "nextButton";
            x.id = "nextButton";
            x.type = "submit";
            var t = document.createTextNode("Next");
            x.appendChild(t);
            document.getElementById("text-field-container").appendChild(x);

            const y = document.createElement("button");
            y.name = "discardButton";
            y.id = "discardButton";
            y.formAction = "../discard.php";
            var u = document.createTextNode("Discard");
            y.appendChild(u);
            y.addEventListener("click", discard);
            document.getElementById("text-field-container").appendChild(y);

        }
    </script>
</head>
<body>
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
    
    <?php
        echo '<h1>Add Judges for  <font color = "#F73634"> Hackathon '.$_SESSION["HName"].'</font></h1>';
    ?>

    <form action="accept_judges_data.php" method="POST" id = "formid">

        <div class = "select-container">
            <p for="judges" id = "instruction">Select the number of judges</p>
            <select name="judgescount" id="judgescount" onclick="generateTextFields()">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </div>

        <div id="text-field-container">
        </div>

    </form> 
    
</body>

<footer>
    <p>Code Battle &copy; 2024. All rights reserved. Made with ❤️ in U.A.E</p>
</footer>
</html>
<!-- //   trying to get only selected category checkboxes
//   $query1="SELECT H_id, Jr_Cadet, Jr_Colonel, Jr_Captain FROM hackathon_data WHERE H_id = :H_id AND 1 IN (Jr_Cadet, Jr_Colonel, Jr_Captain);;";
//   $stmt=$pdo->prepare($query1);
//   $stmt->bindParam(":H_id",$_SESSION['H_id']);
//   $stmt->execute();
//   $result=$stmt->fetchAll(PDO::FETCH_ASSOC);
//   var_dump($result);
  
//   foreach($result[0] as $key=>$value){
//       if ($value==1){
//           $key1[]=$key;
//       }
//   } -->