<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Member Details</title>
    <!-- Add custom styles and theme -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        .container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #4CAF50;
        }
        .container label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        .container input[type="text"],
        .container input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container button {
            padding: 10px 20px;
            margin: 10px 5px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }
        .container .next {
            background-color: #4CAF50;
            color: white;
        }
        .container .discard {
            background-color: #f44336;
            color: white;
        }
        .container button:hover {
            opacity: 0.8;
        }
        #discardMessage {
            color: red;
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Enter Details of Member</h2>
        <form id="memberForm">
            <label for="school">School:</label>
            <input type="text" id="school" name="school" required>

            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="firstName" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <button type="button" class="discard" onclick="discardTeam()">Discard Team</button>
            <button type="submit" class="next">Next</button>
        </form>
        <p id="discardMessage">Team details have been discarded.</p>
    </div>

    <script>
        function discardTeam() {
            document.getElementById('school').value = '';
            document.getElementById('firstName').value = '';
            document.getElementById('email').value = '';
            document.getElementById('discardMessage').style.display = 'block';
        }
    </script>
</body>
</html>