<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Member Details</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: url(https://github.com/N0ZA/Code-Battle-Project/blob/main/Images/grids.jpeg?raw=true) no-repeat center center fixed;
            background-size: cover;
        }
        .navbar {
            background-color: #F73634;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            color: white;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }
        .navbar-nav {
            display: flex;
        }
        .nav-link {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            cursor: pointer; /* Adding cursor pointer for links */
            transition: color 0.3s ease; /* Smooth transition for color change */
        }
        .nav-link.active {
            color: lightgray; /* Change color when link is active */
        }
        .form-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
            padding: 20px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .form-container h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }
        .form-container h2 span {
            color: #F73634;
        }
        .form-group {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        .form-group label {
            width: 80px;
            margin-right: 10px;
        }
        .form-group input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 20px;
            box-sizing: border-box;
        }
        button {
            background-color: #F73634;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            border-radius: 20px;
            cursor: pointer;
            margin-top: 10px;
        }
        footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 5px;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            font-size: 12px;
        }
        footer p .heart {
            color: #F73634;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-brand">
            <img src="https://codebattle.tech/wp-content/uploads/2021/03/cropped-CBTM-transparent-300x159-1.png" alt="CodeBattle Image">
        </div>
        <div class="navbar-nav">
            <a href="#" class="nav-link" onclick="toggleActive(this)">View Hackathon</a>
            <a href="#" class="nav-link" onclick="toggleActive(this)">Edit Teams</a>
            <a href="#" class="nav-link" onclick="toggleActive(this)">Logout</a>
        </div>
    </nav>
    <div class="form-container">
        <h2>Enter <span>Member Details</span></h2>
        <form id="memberForm">
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
            <button type="button" onclick="discardTeam()">Discard Team</button>
            <button type="submit">Next</button>
        </form>
    </div>
    
    <footer>
        <p>Code Battle © 2024. All rights reserved. Made with <span class="heart">❤</span> in U.A.E</p>
        <p>Contact us at: info@codebattle.com</p>
    </footer>
    
    <script>
        function discardTeam() {
            document.getElementById('school').value = '';
            document.getElementById('firstName').value = '';
            document.getElementById('email').value = '';
            alert('Team details have been discarded.');
        }
        function toggleActive(link) {
            // Toggle active class on the clicked link
            link.classList.toggle('active');
        }
    </script>
</body>
</html>