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


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the email from the form
    $email = $_POST["email"];

    // Add your password reset logic here
    // For example, you might generate a unique token and send it to the user's email
    // You could also update the password in the database if a valid token is provided

    // For demonstration purposes, let's assume we send a confirmation message
    $confirmationMessage = "Password reset instructions have been sent to your email.";

    // Display the confirmation message
    echo $confirmationMessage;
}

// Close the database connection
$conn->close();
?>
