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

// Retrieve data from the POST request
$noteId = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];

// Prepare and bind the SQL statement to update the note
$stmt = $conn->prepare("UPDATE notetable SET title = ?, description = ? WHERE id = ?");
$stmt->bind_param("ssi", $title, $description, $noteId);

// Execute the update statement
if ($stmt->execute()) {
    echo "Note updated successfully";
} else {
    echo "Error: " . $conn->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>