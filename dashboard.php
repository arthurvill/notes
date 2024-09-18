<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

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
        
        // Check if we are updating an existing note
        if (isset($_POST["update_id"]) && !empty($_POST["update_id"])) {
            $update_id = $_POST["update_id"];
            $sql = "UPDATE notes SET title=?, description=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $title, $description, $update_id);
        } else {
            $sql = "INSERT INTO notes (title, description) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $title, $description);
        }

        // Execute SQL statement
        if ($stmt->execute()) {
            echo "Note updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close statement
        $stmt->close();
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Passion+One:wght@400;700;900&display=swap" rel="stylesheet">
</head>

<style>
    /* Import Google Font - Poppins */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: white;
    }

    ::selection {
        color: white;
        background: white;
    }

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 250px;
        height: 100%;
        background: #ff895d;
        padding: 20px;
        box-sizing: border-box;
        color: #005689;
    }

    .sidebar h1 {
        font-family: "Passion One", sans-serif;
        /* Change font family here */
        font-size: 50px;
        /* Change font size here */
    }

    .sidebar h1 span {
        font-family: "Passion One", sans-serif;
        /* Change font family here */
    }

    .sidebar ul {
        list-style: none;
        padding: 0;
    }

    .sidebar ul li {
        margin-bottom: 15px;
        position: relative;
        /* To position the icon */
        display: flex;
        /* Flex container for aligning content */
        align-items: center;
        /* Align items vertically */
    }

    .sidebar ul li a {
        text-decoration: none;
        color: black;
        font-size: 18px;
        margin-left: 10px;
        /* Adjust the distance between icon and text */
    }

    .sidebar ul li .icon {
        width: 20px;
        /* Adjust icon size */
        height: auto;
        /* Maintain aspect ratio */
        margin-right: 10px;
        /* Adjust the distance between icon and text */
    }

    .sidebar ul li:hover {
        background-color: rgba(255, 255, 255, 0.1);
        /* Adjust the background color on hover */
        cursor: pointer;
    }

    .sidebar ul li:hover a {
        color: white;
        /* Adjust the text color of anchor tag on hover */
    }

    .sidebar ul li:hover .icon {
        filter: invert(1);
        /* Adjust icon color on hover */
    }

    .wrapper {
        margin: 20px 20px 20px 270px;
        /* Adjusted margin to accommodate the sidebar */
        display: grid;
        gap: 25px;
        grid-template-columns: repeat(auto-fill, 265px);
    }

    .wrapper li {
        height: 250px;
        list-style: none;
        border-radius: 15px;
        padding: 15px 20px 20px;
        background: #d5eeff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .add-box,
    .icon,
    .bottom-content,
    .popup,
    header,
    .settings .menu li {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .add-box {
        cursor: pointer;
        flex-direction: column;
        justify-content: center;
    }

    .add-box .icon {
        height: 78px;
        width: 78px;
        color: black;
        font-size: 40px;
        border-radius: 50%;
        justify-content: center;
        border: 2px dashed black;
    }

    .add-box p {
        color: black;
        font-weight: 500;
        margin-top: 20px;
    }

    .note {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .note .details {
        max-height: 165px;
        overflow-y: auto;
    }

    .note .details::-webkit-scrollbar,
    .popup textarea::-webkit-scrollbar {
        width: 0;
    }

    .note .details:hover::-webkit-scrollbar,
    .popup textarea:hover::-webkit-scrollbar {
        width: 5px;
    }

    .note .details:hover::-webkit-scrollbar-track,
    .popup textarea:hover::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 25px;
    }

    .note .details:hover::-webkit-scrollbar-thumb,
    .popup textarea:hover::-webkit-scrollbar-thumb {
        background: #e6e6e6;
        border-radius: 25px;
    }

    .note p {
        font-size: 22px;
        font-weight: 500;
    }

    .note span {
        display: block;
        color: #575757;
        font-size: 16px;
        margin-top: 5px;
    }

    .note .bottom-content {
        padding-top: 10px;
        border-top: 1px solid #6a93f8;
    }

    .bottom-content span {
        color: #6D6D6D;
        font-size: 14px;
    }

    .bottom-content .settings {
        position: relative;
    }

    .bottom-content .settings i {
        color: #6D6D6D;
        cursor: pointer;
        font-size: 15px;
    }

    .settings .menu {
        z-index: 1;
        bottom: 0;
        right: -5px;
        padding: 5px 0;
        background: #d5eeff;
        position: absolute;
        border-radius: 4px;
        transform: scale(0);
        transform-origin: bottom right;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
        transition: transform 0.2s ease;
    }

    .settings.show .menu {
        transform: scale(1);
    }

    .settings .menu li {
        height: 25px;
        font-size: 16px;
        margin-bottom: 2px;
        padding: 17px 15px;
        cursor: pointer;
        box-shadow: none;
        border-radius: 0;
        justify-content: flex-start;
    }

    .menu li:last-child {
        margin-bottom: 0;
    }

    .menu li:hover {
        background: white;
    }

    .menu li i {
        padding-right: 8px;
    }

    .popup-box {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 999;
    }

    .popup {
        position: relative;
        width: 90%;
        max-width: 600px;
        height: 300px;
        background: #fff;
        border-radius: 8px;
        transform: translate(-50%, -50%);
        padding: 30px;
    }

    .popup .title {
        font-size: 22px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .popup textarea {
        width: 100%;
        height: 100px;
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 5px;
        resize: none;
    }

    .popup button {
        background: #ff895d;
        border: none;
        padding: 10px 20px;
        color: #fff;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    .popup button:hover {
        background: #e57547;
    }

    .popup button:active {
        background: #d05a30;
    }

    .popup .close {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 18px;
        cursor: pointer;
    }

    .popup .close:hover {
        color: red;
    }

    header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    header .left {
        font-size: 24px;
        font-weight: 600;
        color: #333;
    }

    header .right i {
        font-size: 24px;
        cursor: pointer;
    }
</style>

<body>
    <div class="sidebar">
        <h1><span>Veri</span>Tech</h1>
        <ul>
            <li><a href="dashboard.php"><i class="uil uil-estate"></i>Dashboard</a></li>
            <li><a href="#"><i class="uil uil-list-ul"></i>Notes</a></li>
            <li><a href="#"><i class="uil uil-cog"></i>Settings</a></li>
            <li><a href="logout.php"><i class="uil uil-sign-out-alt"></i>Logout</a></li>
        </ul>
    </div>
    <div class="wrapper">
        <div class="add-box" id="addBox">
            <div class="icon">
                <i class="uil uil-plus"></i>
            </div>
            <p>Add Note</p>
        </div>
        <!-- Sample note box -->
        <li>
            <div class="note">
                <div class="details">
                    <p>Note Title</p>
                    <span>Note Description</span>
                </div>
                <div class="bottom-content">
                    <span>Today</span>
                    <div class="settings">
                        <i class="uil uil-cog"></i>
                        <ul class="menu">
                            <li onclick="updateNote()">Edit</li>
                            <li>Delete</li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>
        <!-- End of sample note box -->
    </div>

    <!-- Popup -->
    <div class="popup-box" id="popupBox" style="display: none;">
        <div class="popup">
            <div class="close" id="closePopup">&times;</div>
            <div class="title" id="popupTitle">Add a Note</div>
            <form action="dashboard.php" method="post">
                <input type="hidden" id="update_id" name="update_id" value="">
                <div class="row title">
                    <label>Title</label>
                    <input type="text" name="title" id="titleInput" spellcheck="false">
                </div>
                <div class="row description">
                    <label>Description</label>
                    <textarea name="description" id="descriptionInput" spellcheck="false"></textarea>
                </div>
                <button type="submit" id="submitBtn">Add Note</button>
            </form>
        </div>
    </div>

    <script>
        const addBox = document.getElementById('addBox');
        const popupBox = document.getElementById('popupBox');
        const closePopup = document.getElementById('closePopup');
        const popupTitle = document.getElementById('popupTitle');
        const titleTag = document.getElementById('titleInput');
        const descTag = document.getElementById('descriptionInput');
        const submitBtn = document.getElementById('submitBtn');

        let isUpdate = false;
        let updateId = null;

        addBox.addEventListener('click', () => {
            popupBox.style.display = 'block';
            titleTag.value = '';
            descTag.value = '';
            submitBtn.innerText = 'Add Note';
            popupTitle.innerText = 'Add a Note';
        });

        closePopup.addEventListener('click', () => {
            popupBox.style.display = 'none';
        });

        function updateNote(noteId, title, filterDesc) {
            let description = filterDesc.replaceAll('<br/>', '\r\n');
            updateId = noteId;
            isUpdate = true;
            addBox.click();
            titleTag.value = title;
            descTag.value = description;
            document.getElementById('update_id').value = noteId; // Set update ID
            popupTitle.innerText = "Update a Note";
            submitBtn.innerText = "Update Note";
        }
    </script>
</body>

</html>
