<?php
declare(strict_types=1);
require_once '../includes/dbh.inc.php';
require_once '../includes/config_session.inc.php';
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
            background-image: url(../Images/grids.jpeg);
            background-size: cover;
            color: white;
            font-family: Tahoma;
            font-size: 16px;
        }

        .search-bar {
            width: 60vw;
            max-width: 500px;
            margin: 0 auto;
            text-align: center;
            padding: 1rem;
        }

        .search-input {
            width: 70%;
            padding: 0.5rem;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 1rem;
        }

        .search-button {
            padding: 0.5rem 1rem;
            background-color: black;
            font-size: medium;
            color: white;
            border: none;
            border-radius: 25px;
            margin-left: 5px;
            cursor: pointer;
        }

        button.search-button:hover{
            text-decoration: none;
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
        #back {
            text-align: center; 
        }

        #back button {
            padding: 0.5rem 2rem;
            border-radius: 25px;
            font-size: large; 
            margin-bottom: 3rem;
        }
        .The-Container {
            display: flex;
            align-items: flex-start;
            text-align: left;
            width: 60vw;
            max-width: 1100px;
            margin: 1rem auto;
            background-color: white;
            color: #000000;
            border-radius: 25px;
            padding: 1rem;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .search-input{
            border-radius: 25px;
        }

        .image-container {
            flex: 0 0 40%;
            margin-right: 1rem;
        }

        .image {
            width: 100%;
            height: auto;
            border-radius: 25px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .details-container {
            flex-grow: 1;
            padding-left: 1rem;
        }

        .Hackathon-Info {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .Hackathon-Info span {
            margin-bottom: 2rem;
        }

        .CATCRI {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .Category,
        .Criteria {
            flex-basis: 50%;
            margin-bottom: 2rem;
            margin-left: 25%;
        }

        .Category dt,
        .Criteria dt {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .Judges {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 2rem;
            /* margin-right: 6rem; */

        }

        .Team span {
            display: inline-block;
            margin-right: 1rem;
            margin-bottom: 2rem;
        }

        h1 {
            text-align: center;
            font-size: large;
            color:black;
        }

        button:hover {
            background-color: #F73634;
            color: white;
        }

        .score-dropdown {
      margin-left: 40px;
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
      cursor:pointer;
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

        footer {
            background-color: #000000;
            color: #ffffff;
            padding: 5px;
            text-align: center;
            position: sticky;
            top: 100%;
        }

        #HName {
            font-family: "Lucida Console";
            font-size: 4rem;
        }

        #Details {
            font-size: xx-large;
            margin-top: 3rem;
            margin-bottom: 0px;

        }

        hr {
            margin: 1.5rem;
        }
        table{
            width: 100%;
        }
        
        #suggestionBox {
            position: relative;
            top: 100%;
            left: 0;
            z-index: 1000;
            max-width: 365px; 
            max-height: 200px;
            overflow-y: auto; 
            background-color: #FFFFFF;
            border: 1px solid #ccc; 
            border-top: none; 
            border-radius: 0 0 5px 5px; /* Shadow */
        }

        .suggestion {
            padding: 5px 10px;
            cursor: pointer;
        
            color:black;
            
        }

        .suggestion:hover {
            background-color: #f0f0f0; 
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
    
    <script>
document.addEventListener("DOMContentLoaded", function() {
    const hackathonInput = document.getElementById("hackathonInput");
    const suggestionBox = document.getElementById("suggestionBox");

    hackathonInput.addEventListener("input", function() {
        const input = hackathonInput.value;
        if (input.length > 0) {
            fetch("get_hackathon_suggestions.php?query=" + input)
                .then(response => response.json())
                .then(data => {
                    suggestionBox.innerHTML = ""; 
                    data.forEach(suggestion => {
                        const option = document.createElement("div");
                        option.classList.add("suggestion");
                        option.textContent = suggestion;
                        option.addEventListener("click", function() {
                            hackathonInput.value = suggestion;
                            suggestionBox.innerHTML = ""; 
                        });
                        suggestionBox.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error("Error fetching suggestions:", error);
                });
        } else {
            suggestionBox.innerHTML = ""; 
        }
    });
});

</script>

</head>
<body>
<div class="preloader">
  <div class="loader"></div>
</div>
<div class="button-container">
        <button class="navButtons" onClick="window.location.href='admin.php';">Home</button>
        <button class="navButtons" onClick="window.location.href='HDetail.php';">View Hackathon</button>
        <button class="navButtons" onClick="window.location.href='create.php';">Create Hackathon</button>
        <div class="scoreboard-dropdown-container" id ="profile-container">
        <button class="dropbtn"><i class="fas fa-user"></i>&#x25BC;</button>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
        <div id ="profile-dropdown" class="score-dropdown">
            <a onclick="window.location.href='../logout.php';">Logout</a>
        </div>
        </div>
    </div>
    <h1 id="Details">Hackathon <font color="#F73634">Details</font>
    </h1>
<div class="search-bar">
    <form id="myForm" action="" method="POST">
        <input name="HName" type="text" class="search-input" placeholder="Enter Hackathon Name" id="hackathonInput">
        <button type="submit" class="search-button">Search</button>
        
    </form>
    <div id="suggestionBox"></div>
</div>


<?php 
if(isset($_POST['HName'])){
    $name=$_POST['HName'];
    $query="SELECT* from hackathon_data where HName=:HName";
    $stmt=$pdo->prepare($query);
    $stmt->bindParam("HName",$name);
    $stmt->execute();
    $result=$stmt->fetch();
    $val=$result['H_id'];
    

    if(!($result)){
        echo "<h1>Invalid Hackathon name</h1>";
        die();
    }
    $query2="SELECT* from criteria_data where H_id=:H_id";
    $stmt2=$pdo->prepare($query2);
    $stmt2->bindParam("H_id",$val);
    $stmt2->execute();
    $result2=$stmt2->fetchAll();


    $query3="SELECT judges_category.username,category.CName from judges_category LEFT JOIN category ON judges_category.C_id = category.C_id where H_id=:H_id;";
    $stmt3=$pdo->prepare($query3);
    $stmt3->bindParam("H_id",$val);
    $stmt3->execute();
    $result3=$stmt3->fetchAll();

    $query4="SELECT COUNT(T_id) as teams from team_data where H_id=:H_id;";
    $stmt4=$pdo->prepare($query4);
    $stmt4->bindParam("H_id",$val);
    $stmt4->execute();
    $result4=$stmt4->fetchAll();

    $query5="SELECT DISTINCT(CNAME) as Categories from judges_category where H_id=:H_id;";
    $stmt5=$pdo->prepare($query5);
    $stmt5->bindParam("H_id",$val);
    $stmt5->execute();
    $result5=$stmt5->fetchAll();

?>
        <div class="The-Container">
            <!-- <div class="image-container">
                <img src="../Images/Hackathon.png" alt="Image" class="image">
            </div> -->
            <div class="details-container">

                <?php// foreach($result as $row){?>
                    <h1 id="HName">
                        <?php echo $result['HName']?>
                    </h1>
                    <hr>
                    <h1>Hackathon</h1>
                    <hr>
                    <div class="timeanddate">
                        <div class="Hackathon-Info">
                            <span>
                                <font color="#F73634">Hackathon ID: </font><label>
                                    <?php echo $result['H_id']?>
                                </label>
                            </span>
                            <span>
                                <font color="#F73634">Date: </font><label>
                                    <?php echo $result['HDate']?>
                                </label>
                            </span>
                            <span>
                                <font color="#F73634">Time: </font><label>
                                    <?php echo $result['HTime']?>
                                </label>
                            </span>
                        </div>
                    </div>
                <?php //}?>


                <div class="CATCRI">

                    <div class="Criteria">
                        <div class="HCriteria">
                            <span>
                                <font color="#F73634">Criteria:-</font>
                            </span>
                            <dl>
                                <?php foreach($result2 as $row){?>
                                    <dt>
                                        <?php echo $row['CRName']?>
                                    </dt>
                                <?php } ?>
                            </dl>
                        </div>
                    </div>
                    <div class="Category">
                        <div class="HCategory">
                            <span>
                                <font color="#F73634">Category:-</font>
                            </span>
                            <dl>
                                <?php foreach($result5 as $row){?>
                                    <dt>
                                        <?php echo $row['Categories']?>
                                    </dt>
                                <?php } ?>
                            </dl>
                        </div>
                    </div>

                </div>

                <hr>
                <h1>Judges</h1>
                <hr>
                <div class="Judges">
                    <?php foreach($result3 as $row){ ?>
                    <table>
                        <tr>
                        <th id="JName">
                            <font color="#F73634">Name: </font>
                            <?php echo $row['username']?><label></label>
                        </th>

                        <th id="JCat">
                            <font color="#F73634">Category: </font>
                            <?php echo $row['CName']?><label></label>
                        </th>
                        </tr>
                    </table>
                    <?php } ?>
                </div>

                <hr>
                <h1>Teams</h1>
                <hr>
                <div class="Team">
                    <?php foreach($result4 as $row){?>
                        <span id="teamno">
                            <font color="#F73634">Registered Teams: </font><label>
                                <?php echo $row['teams']?>
                            </label>
                        </span>
                    <?php } ?>
                </div>
            </div>
        </div>

        <form id="back" action="admin.php" method="POST">
            <button type="submit" class="search-button">Go Back</button>
        </form>
        <footer>
            <p>Code Battle &copy; 2024. All rights reserved. Made with ❤️ in U.A.E</p>
        </footer>
         <?php }?>
        <script>

function load(){
    const preloader = document.querySelector('.preloader');
    preloader.style.display = 'none';
}

window.addEventListener('load', load);

</script>
</body>
       

</html>
