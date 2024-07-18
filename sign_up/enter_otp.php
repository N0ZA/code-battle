<?php
    require_once "verify_email.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['otp']) || !isset($_SESSION['otp_time'])){
        header("Location: signup.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>OTP Email Verification</title>

    <style>
        body {
            width: 100%;
            height: 100vh;
            margin: 0;
            background-color: #E3E3E3;
            background-image: url(https://github.com/N0ZA/code-battle/blob/main/images/grids.jpeg?raw=true);
            background-size: cover;
            color: black;
            font-family: Tahoma;
            font-size: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wrapper {
            background: red;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .otp h2 {
            color: white;
            margin: 0 0 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        .form-group input[type="submit"] {
            width: calc(100%);
            background: #000000;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .form-group input[type="submit"]:hover {
            background: #A9A9A9;
        }
    </style>
</head>

<body>
	<div class="wrapper">
		<div class="otp">
			<h2>OTP Verify</h2>
			<hr>		
			<form action="verify_email.php" method="POST">
				<div class="form-group">
					<input type="text" name="USERotp" placeholder="Enter 6 digit OTP to verify email" required pattern="\d{6}">
				</div>
				<div class="form-group">
					<label></label>
					<input type="submit" name="verify" value="Verify">
                    <?php
                        check_otp_errors();
                    ?>
				</div>
			</form>
		</div>
	</div>

</body>

</html>
