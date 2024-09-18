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
    // Check if all required fields are filled
    if (isset($_POST["title"]) && isset($_POST["description"])) {
        // Prepare SQL statement to insert a new note into the database
        $title = $_POST["title"];
        $description = $_POST["description"];
        $sql = "INSERT INTO notes (title, description) VALUES ('$title', '$description')";

        // Execute SQL statement
        if ($conn->query($sql) === TRUE) {
            echo "New note added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Title and description are required";
    }
}

// Close database connection
$conn->close();
?>