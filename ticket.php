<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Ticket </title>
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
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .nav-link.active {
            color: lightgray;
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
        .qr-code {
            width: 100%;
            height: 200px;
            background-color: #f0f0f0;
            margin-bottom: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 14px;
            color: #999;
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
    <div class="form-container" id="ticket-container">
        <h2>Team <span>Ticket Generator</span></h2>
        <div class="form-group">
            <label for="teamName">Team Name</label>
            <input type="text" id="teamName" placeholder="Enter team name">
        </div>
        <div class="form-group">
            <label for="school">School</label>
            <input type="text" id="school" name="school" placeholder="Enter school name" required>
        </div>
        <div class="form-group">
            <label for="members">Members</label>
            <input type="text" id="members" name="members" placeholder="Enter team members" required>
        </div>
        <div class="form-group">
            <label for="eventDate">Event Date</label>
            <input type="date" id="eventDate" name="eventDate" required>
        </div>
        <button type="button" onclick="generateQRCode()">Generate QR Code</button>
        <div class="qr-code" id="qrcode">
            QR Code will be generated here
        </div>
    </div>
    
    <footer>
        <p>Code Battle © 2024. All rights reserved. Made with <span class="heart">❤</span> in U.A.E</p>
        <p>Contact us at: info@codebattle.com</p>
    </footer>
    
    <!-- Include qrcode.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        function toggleActive(link) {
            document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));
            link.classList.add('active');
        }

        function generateQRCode() {
            const teamName = document.getElementById("teamName").value;
            const qrCodeElement = document.getElementById("qrcode");
            if (teamName) {
                qrCodeElement.innerHTML = ''; // Clear previous QR code if any
                new QRCode(qrCodeElement, {
                    text: teamName,
                    width: 200,
                    height: 200
                });
            } else {
                alert("Please enter the team name.");
            }
        }
    </script>
</body>
</html>