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

    // Function to toggle favorite status
    function toggleFavorite($note_id, $is_favorite) {
        global $conn;
        $sql = "UPDATE notess SET is_favorite = $is_favorite WHERE id = $note_id";
        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    // Function to toggle archive status
    function toggleArchive($note_id, $is_archived) {
        global $conn;
        $sql = "UPDATE notess SET is_archived = $is_archived WHERE id = $note_id";
        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    // Handle requests to toggle favorite or archive status
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["note_id"]) && isset($_POST["action"])) {
            $note_id = $_POST["note_id"];
            $action = $_POST["action"];
            if ($action == "favorite") {
                $is_favorite = $_POST["is_favorite"] == "true" ? 0 : 1;
                echo toggleFavorite($note_id, $is_favorite);
            } elseif ($action == "archive") {
                $is_archived = $_POST["is_archived"] == "true" ? 0 : 1;
                echo toggleArchive($note_id, $is_archived);
            }
            exit;
        }
    }
?>
