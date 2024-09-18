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

// Initialize the variable to store the success message
$successMessage = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    // Prepare and bind SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO register (r_username, r_email, r_password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    // Execute and check for success
    if ($stmt->execute()) {
        // Set success message if record is created successfully
        $successMessage = "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
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
    <title>Register</title>
    <style>
        /* Custom Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-image: linear-gradient(120deg, #c2e9fb 0%, #c2e9fb 100%);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            overflow: hidden; /* Prevent scrolling */
            background-color: #15202b;
        }
        
        .navbar {
            background-color: none; /* Change background color to white */
            color: #005689; /* Change text color to black */
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
            color:  #fb8500; /* Changed color of "Note" to black */
            font-family: "Passion One", sans-serif;
        }
        
        .navbar ul {
            list-style-type: none;
            margin-right: 10px;
            padding: 15px;
            color: white;
        }
        
        .navbar ul li {
            display: inline;
            margin-right: 20px;
            font-size: 20px;
        }
        
        .navbar ul li a {
            text-decoration: none;
            color: black; /* Change text color to black */
            font-family: Arial, Helvetica, sans-serif;
            padding: 15px 15px;
        }

        /* Hover effect for navigation links */
        .navbar ul li a:hover {
            color: #fb8500; /* Change text color on hover */
            transition: color 0.3s;
        background-color: #d5eeff; /* Add background color on hover */
      border-radius: 10px;

        }
        
        .main {
            display: flex;
            justify-content: center; /* Center content horizontally */
            align-items: center; /* Center content vertically */
            min-height: 87vh; /* Set minimum height to full viewport height */
            position: relative; /* Add position relative for absolute positioning */
            z-index: 1; /* Ensure form is above the blurred background */
        }

        .form-container {
            width: 100%; /* Full width */
            max-width: 450px; /* Maximum width for the form container */
            padding: 40px; /* Adjusted padding for larger container */
            background-image: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
            border-radius: 50px;
            box-shadow: 0px 1px 12px 0px #15202b3d;
            backdrop-filter: blur(3px); /* Apply blur effect to the background */
            
        }
        
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #005689;
            font-size: 50px; /* Increased font size for "NoteIt!" inside the form container */
            font-family: "Passion One", sans-serif;
        }

        .register-color {
            color:  #fb8500; /* Color for "ter" in Register */
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
            border: 1px solid black;
            border-radius: 10px;
            box-sizing: border-box;
            background-color: transparent;
            color: black;
        }

        .error-message {
            color: red ;
            font-size: 0.8em;
            position: absolute;
            top: 100%;
            left: 0;
        }
        
        .button {
            width: 30%;
            margin: 0 auto;
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
            box-shadow: 0 0px 20px rgba(193, 163, 98,0.4);
        }

        .button:active {
            scale: 1;
        }

        /* Success Message Animation */
        .success-message {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: red;
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            animation: fadeIn 0.5s ease-in-out forwards;
            display: none;
            z-index: 1000; /* Ensure it's above other elements */
            font-weight: bold;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-title">Note<span class="black">It!</span></div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="register.php">Sign Up</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <div class="main">
        <!-- Form container -->
        <div class="form-container">
            <h2>Note<span class="register-color">It!</span></h2> <!-- Changed color of "ter" in Register -->
            <form id="registerForm" method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                    <div class="error-message" id="errorUsername"></div>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                    <div class="error-message" id="errorEmail"></div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                    <div class="error-message" id="errorPassword"></div>
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                    <div class="error-message" id="errorConfirmPassword"></div>
                </div>
                <button type="button" onclick="submitForm()" class="button">Register</button>
            </form>
        </div>
    </div>

    <!-- Success message container -->
    <div id="successMessage" class="success-message"><?php echo $successMessage; ?></div>

    <script>
        function submitForm() {
            if (validateForm()) {
                document.getElementById("registerForm").submit();
            }
        }

        function validateForm() {
            var username = document.getElementById("username").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm-password").value;
            var isValid = true;

            document.getElementById("errorUsername").innerText = "";
            document.getElementById("errorEmail").innerText = "";
            document.getElementById("errorPassword").innerText = "";
            document.getElementById("errorConfirmPassword").innerText = "";

            if (username.trim() === "") {
                document.getElementById("errorUsername").innerText = "Please enter your username";
                isValid = false;
            }

            if (email.trim() === "") {
                document.getElementById("errorEmail").innerText = "Please enter your email";
                isValid = false;
            }

            if (password.trim() === "") {
                document.getElementById("errorPassword").innerText = "Please enter your password";
                isValid = false;
            }

            if (confirmPassword.trim() === "") {
                document.getElementById("errorConfirmPassword").innerText = "Please confirm your password";
                isValid = false;
            }

            if (password !== confirmPassword) {
                document.getElementById("errorConfirmPassword").innerText = "Passwords do not match";
                isValid = false;
            }

            return isValid;
        }

        // Display success message with animation
        var successMessage = document.getElementById("successMessage");
        if (successMessage.innerHTML !== "") {
            successMessage.style.display = "block";
            setTimeout(function() {
                successMessage.style.display = "none";
            }, 3000); // Hide after 3 seconds
        }
    </script>
</body>
</html>
