<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Member Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: black;
            margin: 0;
            padding: 0;
            background-color: #E3E3E3;
            background-image: url('Images/grids.jpeg');
            background-size: cover;
            overflow-x: hidden;
        }
        .container {
            display: flex;
            flex-direction: column; /* Stack items vertically */
            align-items: center; /* Center items horizontally */
            max-width: 700px; /* Increased max width */
            margin: 1rem auto;
            background-color: #FAFAFA;
            color: black;
            border-radius: 25px;
            padding: 2rem; /* Reduced padding */
            box-sizing: border-box;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center; /* Center items horizontally */
            text-align: center; /* Center text */
            width: 100%; /* Medium width of container */
            max-width: 400px; /* Maximum width of container */
            padding: 1.5rem; /* Reduced padding */
            border-radius: 15px; /* Rounded corners */
            background-color: #FAFAFA; /* White background */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow for depth */
        }
        .form-container h4 {
            padding: 10px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 1rem; /* Reduced margin */
            width: 100%;
        }
        .form-group label {
            display: block;
            text-align: left;
        }
        .form-group input {
            border: 1px solid #cccccc;
            border-radius: 35px;
            font-size: 1rem;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            border: none;
            border-radius: 25px;
            color: #ffffff;
            font-size: 1rem;
            padding: 0.5rem;
            width: 100%;
            margin-top: 1rem; /* Reduced margin */
        }
        button.discard {
            background-color: #f44336;
        }
        button:hover {
            opacity: 0.8;
        }
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #272727;
            color: #4CAF50;
            font-size: x-large;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .loader {
            border: 8px solid #0000007c;
            border-top: 8px solid #4CAF50;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .logo {
            margin-bottom: 20px;
            text-align: center;
        }
        .logo img {
            max-width: 150px; /* Adjusted size */
            height: auto;
            display: block;
            margin: auto; /* Center image horizontally */
            cursor: zoom-in;
            background-color: white; /* White background around image */
            border-radius: 15px; /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Shadow for depth */
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
        footer p {
            margin: 0;
        }
        footer p span {
            color: red; /* Red color for heart emoji */
        }
    </style>
</head>
<body>
    <div class="preloader">
        <div class="loader"></div>
    </div>

    <div class="container">
        <div class="logo">
            <img src="http://localhost/Images/logob.png" alt="CodeBattle Image">
        </div>
        
        <div class="form-container">
            <h1><font color="Black">Enter</font> <font color="#4CAF50">Member Details</font></h1>
            <form id="memberForm">
                <h4><font color="Black">Please enter the details below.</font></h4>
                <div class="form-group">
                    <label for="school">School:</label>
                    <input type="text" id="school" name="school" required>
                </div>
                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <button type="button" class="discard" onclick="discardTeam()">Discard Team</button>
                <button type="submit" class="next">Next</button>
            </form>
            <p id="discardMessage" style="color: red; display: none;">Team details have been discarded.</p>
        </div>
    </div>

    <footer>
        <p>Code Battle &copy; 2024. All rights reserved. Made with <span style="color: red;">❤</span> in U.A.E</p>
    </footer>

    <script>
        function discardTeam() {
            document.getElementById('school').value = '';
            document.getElementById('firstName').value = '';
            document.getElementById('email').value = '';
            document.getElementById('discardMessage').style.display = 'block';
        }

        function load() {
            const preloader = document.querySelector('.preloader');
            preloader.style.display = 'none';
        }

        window.addEventListener('load', load);
    </script>
</body>
</html>