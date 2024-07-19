
<?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Code Battle</title>

    <style>
        body {
            width: 100%;
            height: 100vh;
            margin: 0;
            background-color: #E3E3E3;
            font-size: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }


    </style>
</head>

<body>
    <a href="../logout.php">Logout</a>

    <h1> DASHBOARD DEMO </h1>

    <a href="../teams/teamReg.php"> HACKATHON 1</a>
    <a href="../teams/teamReg.php"> HACKATHON 2</a>
    <a href="../teams/teamReg.php"> HACKATHON 3</a>

</body>

</html>