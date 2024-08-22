<?php
    require_once "../includes/dbh.inc.php";
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_isadmin'])) {
        header("Location: index.php");
        exit();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Scanner</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">

    <script>
        window.addEventListener('load', function(){
            const preloader = document.querySelector('.preloader');
            preloader.style.display = 'none';
        });
    </script>

    <style>
        @font-face {
            font-family: 'Montserrat';
            src: url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap');
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: url('https://github.com/N0ZA/code-battle/blob/main/Images/grids.jpeg?raw=true') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding-top: 50px;
            color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f44134;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .logo {
            height: 40px;
            margin-right: 20px;
        }

        .nav {
            list-style: none;
            display: flex;
            padding: 0;
            margin: 0;
        }

        .nav li {
            margin: 0 10px;
        }

        .nav li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        .nav li a:hover {
            text-decoration: underline;
        }

        .dropdown-container {
            position: relative;
        }

        .dropbtn {
            background-color: #f44134;
            color: white;
            border: none;
            padding: 10px;
            font-size: 16px;
            cursor: pointer;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown-container:hover .dropdown-content {
            display: block;
        }

        #camera-view {
            width: 90%;
            max-width: 400px;
            aspect-ratio: 1;
            border-radius: 15px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }

        #loading {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 18px;
            background: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 15px;
            border-radius: 8px;
        }

        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .loader {
            border: 8px solid #f3f3f3;
            border-top: 8px solid #f44134;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .nav li {
                margin: 0 5px;
            }

            .dropbtn {
                padding: 8px;
                font-size: 14px;
            }

            #loading {
                font-size: 16px;
                padding: 10px;
            }
        }

        @media (max-width: 480px) {
            .nav {
                flex-direction: column;
                align-items: center;
            }

            .header-left {
                flex-direction: column;
            }

            .nav li {
                margin: 5px 0;
            }

            .header-right {
                padding-right: 0;
            }

            .dropbtn {
                font-size: 14px;
                padding: 8px;
            }
        }
        .scan-title {
            background-color:#f44134 ;   /*rgba(255, 255, 255, 0.8);*/
            padding: 10px;
            margin: auto;
            width: 40%;
            font-size: larger;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            text-align: center;
            color: white;
        }
    </style>
</head>
<body>
    <div class="preloader">
        <div class="loader"></div>
    </div>

    <div class="header">
        <div class="header-left">
            <img src="../images/codebattlelogo.png" alt="Logo" class="logo">
            <ul class="nav">
                <!--<li><a href="../dashboard.php">Home</a></li>-->
                <li><a href="../events/registered_events.php">Registered Events</a></li>
            </ul>
        </div>
        <div class="header-right">
            <div class="dropdown-container">
                <button class="dropbtn"><i class="fas fa-user"></i>&#x25BC;</button>
                <div id="profile-dropdown" class="dropdown-content">
                    <a onclick="window.location.href='../logout.php';">Logout</a>
                </div>
            </div>
        </div>
    </div>
    
        <?php if (isset($_GET['status']) && $_GET['status']=='checked_in'):?>
            <div class="scan-title">
                <h2>Checked In!</h2>
            </div>
            <div class="scan-title">
                <h2 onclick="window.location.href='qr_scanner.php';" style="cursor: pointer;">SCAN NEXT</h2> 
            </div>
        <?php else:?>
            <div class="scan-title">
                <h2>Scan your Tickets!</h2>
            </div>
        <?php endif ?>

    <?php if (!isset($_GET['status']) || $_GET['status']!='checked_in'): ?>
        <div class="content-container"></div>
        <div id="camera-view">
            <video id="camera" autoplay></video>
            <div id="loading">Scanning...</div>
        </div>
    <?php endif ?>
    <script src="https://cdn.jsdelivr.net/npm/jsqr@1.4.0/dist/jsQR.min.js"></script>


    <script>
        const video = document.getElementById('camera');
        const loading = document.getElementById('loading');

        if (video) {
            function startCamera() {
                navigator.mediaDevices.getUserMedia({ video: { facingMode: 'environment' } })
                    .then(stream => {
                        video.srcObject = stream;
                    })
                    .catch(err => {
                        alert('Error accessing the camera: ' + err.message);
                    });
            }
        }
        function scanQRCode() {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');

            setInterval(() => {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                const imageData = context.getImageData(0, 0, canvas.width, canvas.height);
                const qrCode = jsQR(imageData.data, canvas.width, canvas.height);

                console.log("Video dimensions:", video.videoWidth, video.videoHeight);
                console.log("QR Code Data:", qrCode ? qrCode.data : "No QR Code detected");

                if (qrCode) {
                    
                    
                    loading.innerText = 'QR Code Detected! Redirecting...';
                    loading.style.display = 'block';

                    // Redirect to the URL in the QR code
                    setTimeout(() => {
                        const qrData=qrCode.data;
                        window.location.href = `process_qr.php?qrData=${encodeURIComponent(qrCode.data)}`;
                       
                    }, 1000); // Add a short delay before redirecting
                }
            }, 300);
        }


        startCamera();
        scanQRCode();
    </script>
</body>
</html>
