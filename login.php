<?php
// Retrieve database configuration from environment variables
$servername = getenv('DB_HOST');
$username = getenv('DB_USERNAME');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_DATABASE');
$port = getenv('DB_PORT') ?: '3306'; // Use default port 3306 if not set

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Fetch hashed password from the database based on the username
    $sql = "SELECT r_username, r_password FROM register WHERE r_username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["r_password"];

        // Verify the provided password with the hashed password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, set session and redirect to dashboard or any authenticated page
            $_SESSION["username"] = $row["r_username"];
            header("Location: dashboard.php");
            exit;
        } else {
            // Password is incorrect, redirect back to login page with an error message
            header("Location: login.php?error=incorrect_credentials");
            exit;
        }
    } else {
        // User does not exist, redirect back to login page with an error message
        header("Location: login.php?error=incorrect_credentials");
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Passion+One:wght@400;700;900&display=swap" rel="stylesheet">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
            background-size: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-color: #15202b;
            height: 100vh;
        }

        /* Rest of your CSS styles */

        .navbar {
            background-color: none;
            color: #005689;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-title {
            margin-left: 20px;
            font-size: 50px;
            color: #005689;
            font-weight: bold;
            font-family: "Passion One", sans-serif;
        }

        .navbar-title .black {
            color: #fb8500;
            font-family: "Passion One", sans-serif;
        }

        .navbar ul {
            list-style-type: none;
            margin-right: 10px;
            padding: 15px;
        }

        .navbar ul li {
            display: inline;
            margin-right: 20px;
            font-size: 20px;
        }

        .navbar ul li a {
            text-decoration: none;
            color: black;
            font-family: Arial, Helvetica, sans-serif;
            transition: color 0.3s;
            padding: 15px 15px;
        }

        .navbar ul li a:hover {
            color: #fb8500;
            background-color: #d5eeff;
            border-radius: 10px;
        }

        .box {
            width: 100%;
            max-width: 450px;
            margin: 140px auto 50px;
            padding: 40px;
            border-radius: 50px;
            background-image: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
            backdrop-filter: blur(3px);
            box-shadow: 0px 1px 12px 0px #15202b3d;
        }

        h2 {
            text-align: center;
            color: #005689;
            font-size: 50px;
            font-family: "Passion One", sans-serif;
        }

        .note-it {
            color: #fb8500;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            font-weight: bold;
            color: black;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #000000;
            border-radius: 10px;
            box-sizing: border-box;
            background-color: transparent;
            color: black;
        }

        .error-message {
            color: red;
            font-size: 0.8em;
            position: absolute;
            top: 100%;
            left: 0;
            display: none;
        }

        .button {
            
            cursor: pointer;
            position: relative;
            padding: 10px 24px;
            font-size: 18px;
            color: black;
            border: 2px solid #fb8500;
            border-radius: 34px;
            background-color: #fb8500;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            overflow: hidden;
            display: block;
        }

        .button::before {
            content: '';
            position: absolute;
            inset: 0;
            margin: auto;
            width: 50px;
            height: 50px;
            border-radius: inherit;
            scale: 0;
            z-index: -1;
            background-color: #fb8500;
            transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
        }

        .button:hover::before {
            scale: 3;
        }

        .button:hover {
            color: white;
            scale: 1.1;
            box-shadow: 0 0px 20px rgba(193, 163, 98, 0.4);
        }

        .button:active {
            scale: 1;
        }
        
        .button-container {
  
    margin-top: 20px;
    display: flex; /* Add this line */
    justify-content: center; /* Add this line */
}

        .forgot-password {
            text-align: right;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="main">
    <nav class="navbar">
        <div class="navbar-title">Note<span class="black">It!</span></div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="register.php">Sign Up</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>
    <form action="" method="post" id="loginform">
        <div class="box">
            <h2>Note<span class="note-it">It!</span></h2>
            <?php
            if (isset($_GET['error']) && $_GET['error'] === 'incorrect_credentials') {
                echo '<p style="color: black; text-align: center;">Incorrect username or password.</p>';
            }
            ?>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username">
                <div class="error-message" id="errorUsername">Please enter your username</div>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password">
                <div class="error-message" id="errorPassword">Please enter your password</div>
            </div>
            <div class="forgot-password">
                <a href="forgot_password.php" style="color: black;">Forgot Password?</a>
            </div>
            <div class="button-container"> <!-- This div centers the button -->
                <button type="submit" class="button">Login</button>
            </div>
        </div>
    </form>
</div>
<script>
    var form = document.getElementById('loginform');

    form.addEventListener('submit', function (event) {
        var username = document.getElementById('username');
        var password = document.getElementById('password');
        var errorUsername = document.getElementById('errorUsername');
        var errorPassword = document.getElementById('errorPassword');
        var isValid = true;

        if (username.value.trim() === '') {
            errorUsername.style.display = 'block';
            isValid = false;
        } else {
            errorUsername.style.display = 'none';
        }

        if (password.value.trim() === '') {
            errorPassword.style.display = 'block';
            isValid = false;
        } else {
            errorPassword.style.display = 'none';
        }

        if (!isValid) {
            event.preventDefault();
        }
    })

    document.addEventListener('DOMContentLoaded', function () {
        var errorMessage = document.querySelector('.error-message');
        if (errorMessage) {
            setTimeout(function () {
                errorMessage.style.display = 'none';
            }, 5000);
        }
    });

    form.addEventListener('input', function (event) {
        var target = event.target;
        var error = target.nextElementSibling;

        if (target.value.trim() !== '') {
            error.style.display = 'none';
        } else {
            error.style.display = 'block';
        }
    });
</script>
</body>
</html>
