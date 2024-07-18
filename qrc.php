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
            background-image: url('http://localhost/images/grids.jpeg');
            background-size: cover;
            overflow-x: hidden;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            max-width: 700px;
            margin: 1rem auto;
            background-color: #FAFAFA;
            color: black;
            border-radius: 25px;
            padding: 2rem;
            box-sizing: border-box;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
            max-width: 400px;
            padding: 1.5rem;
            border-radius: 15px;
            background-color: #FAFAFA;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            margin-bottom: 0.5rem;
            font-size: 1.5rem; /* Adjusted font size */
        }
        .form-container h1 font[color="#4CAF50"] {
            color: red; /* Changed color to red */
        }
        .form-container h4 {
            padding: 5px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 1rem;
            width: 100%;
            text-align: left; /* Align labels and inputs to the left */
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem; /* Adjusted margin for labels */
            font-weight: bold; /* Added bold font for labels */
        }
        .form-group input {
            border: 1px solid #cccccc;
            border-radius: 35px;
            font-size: 1rem;
            padding: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        .form-group input::placeholder {
            color: #aaa;
        }
        button {
            background-color: #f44336; /* Deep red */
            border: none;
            border-radius: 25px;
            color: #ffffff;
            font-size: 1rem;
            padding: 0.5rem;
            width: 100%;
            margin-top: 1rem;
            transition: background-color 0.3s ease; /* Added transition effect */
        }
        button.discard:hover {
            background-color: #c62828; /* Darker red on hover */
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
            margin-bottom: 10px; /* Reduced margin */
            text-align: center;
        }
        .logo img {
            max-width: 200px;
            height: auto;
            display: block;
            margin: auto;
            cursor: zoom-in;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        footer {
            background-color: #000000;
            color: #ffffff;
            padding: 5px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 10px; /* Adjusted height */
        }
        footer p {
            margin: 0;
            position: absolute;
            bottom: 0;
            width: 100%;
            padding: 5px;
            background-color: #000000;
            color: #ffffff;
            text-align: center;
        }
        footer p span {
            color: red;
        }
    </style>
</head>
<body>
    <div class="preloader">
        <div class="loader"></div>
    </div>

    <div class="container">
        <div class="logo">
            <img src="http://localhost/images/logob.png" alt="CodeBattle Image">
        </div>
        
        <div class="form-container">
            <h1><font color="Black">Enter</font> <font color="#4CAF50">Member Details</font></h1> <!-- Changed color of "Member Details" to red -->
            <form id="memberForm">
                <h4><font color="Black">Please enter the details below.</font></h4>
                <div class="form-group">
                    <label for="school">School</label>
                    <input type="text" id="school" name="school" placeholder="Enter your school name" required>
                </div>
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <button type="button" class="discard" onclick="discardTeam()">Discard Team</button>
                <button type="submit" class="next" style="background-color: red;">Next</button> <!-- Changed color of "Next" button to red -->
            </form>
            <p id="discardMessage" style="color: red; display: none;">Team details have been discarded.</p>
        </div>
    </div>

    <footer>
        <p>Code Battle &copy; 2024. All rights reserved. Made with <span style="color: red;">❤</span> in U.A.E</p> <!-- Adjusted margin to 0 -->
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