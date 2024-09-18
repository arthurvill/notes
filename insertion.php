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

// Function to sanitize user inputs
function sanitizeInput($input) {
    // Use mysqli_real_escape_string or any other appropriate method
    return htmlspecialchars(strip_tags($input));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $noteTitle = sanitizeInput($_POST['n_title']);
    $noteDesc = sanitizeInput($_POST['n_desc']);

    // Prepare and bind SQL statement
    $stmt = $conn->prepare("INSERT INTO notetable (n_title, n_desc) VALUES (?, ?)");
    $stmt->bind_param("ss", $noteTitle, $noteDesc);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Note added successfully.";
    } else {
        echo "Error adding note: " . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Fetch all notes from the database
$sql = "SELECT * FROM notetable";
$result = $conn->query($sql);
$notes = [];

if ($result->num_rows > 0) {
    // Fetch all rows and store them in the $notes array
    while ($row = $result->fetch_assoc()) {
        $notes[] = $row;
    }
}

// Close connection
$conn->close();

// Return the fetched notes as JSON
echo json_encode($notes);

?>
