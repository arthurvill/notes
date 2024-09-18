<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in, if not redirect to login page
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

// Retrieve the logged-in user's name from the session

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
if ($_SERVER["REQUEST_METHOD"] == "POST") 
    // Check if all required fields are filled
    if (isset($_POST["title"]) && isset($_POST["description"])) {
        // Prepare SQL statement to insert a new note into the database
$title = $_POST["title"];
$description = $_POST["description"];
$sql = "INSERT INTO notes (title, description) VALUES (?, ?)";

// Prepare and bind parameters
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $title, $description);

// Execute SQL statement
if ($stmt->execute()) {
    echo "New note added successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close statement
$stmt->close();

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
        z-index: 2;
        height: 100%;
        width: 100%;
        background: rgba(0, 0, 0, 0.4);
    }

    .popup-box .popup {
        position: absolute;
        top: 50%;
        left: 50%;
        z-index: 3;
        width: 100%;
        max-width: 400px;
        justify-content: center;
        transform: translate(-50%, -50%) scale(0.95);
    }

    .popup-box,
    .popup {
        opacity: 0;
        pointer-events: none;
        transition: all 0.25s ease;
    }

    .popup-box.show,
    .popup-box.show .popup {
        opacity: 1;
        pointer-events: auto;
    }

    .popup-box.show .popup {
        transform: translate(-50%, -50%) scale(1);
    }

    .popup .content {
        border-radius: 20px;
        background: #fff;
        width: calc(100% - 15px);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    .content header {
        padding: 15px 25px;
        border-bottom: 1px solid #ccc;
    }

    .content header p {
        font-size: 20px;
        font-weight: 500;
    }

    .content header i {
        color: #8b8989;
        cursor: pointer;
        font-size: 23px;
    }

    .content form {
        margin: 15px 25px 35px;
    }

    .content form .row {
        margin-bottom: 20px;
    }

    form .row label {
        font-size: 18px;
        display: block;
        margin-bottom: 6px;
    }

    form :where(input, textarea) {
        height: 50px;
        width: 100%;
        outline: none;
        font-size: 17px;
        padding: 0 15px;
        border-radius: 4px;
        border: 1px solid #999;
    }

    form :where(input, textarea):focus {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.11);
    }

    form .row textarea {
        height: 150px;
        resize: none;
        padding: 8px 15px;
    }

    form button {
        width: 100%;
        height: 50px;
        color: #fff;
        outline: none;
        border: none;
        cursor: pointer;
        font-size: 17px;
        border-radius: 4px;
        background: #6A93F8;
    }

    @media (max-width: 660px) {
        .wrapper {
            margin: 15px;
            gap: 15px;
            grid-template-columns: repeat(auto-fill, 100%);
        }

        .popup-box .popup {
            max-width: calc(100% - 15px);
        }

        .bottom-content .settings i {
            font-size: 17px;
        }
    }

    .favorite {
        color: red;
    }

    .notes-container {
        display: grid;
        gap: 25px;
        grid-template-columns: repeat(auto-fill, 265px);
        margin-left: 250px;
        /* Adjusted margin to accommodate the sidebar */
        padding: 20px;
    }

    .notes-container .note {
        height: 250px;
        border-radius: 5px;
        padding: 15px 20px 20px;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
    }

    .notes-container .note .details {
        max-height: 165px;
        overflow-y: auto;
    }

    .notes-container .note p {
        font-size: 22px;
        font-weight: 500;
    }

    .notes-container .note span {
        display: block;
        color: #575757;
        font-size: 16px;
        margin-top: 5px;
    }

    .notes-container .note .bottom-content {
        padding-top: 10px;
        border-top: 1px solid #ccc;
    }

    .notes-container .bottom-content span {
        color: #6d6d6d;
        font-size: 14px;
    }

    .notes-container .bottom-content .settings {
        position: relative;
    }

    .notes-container .bottom-content .settings i {
        color: #6d6d6d;
        cursor: pointer;
        font-size: 15px;
    }

    .notes-container .settings .menu {
        z-index: 1;
        bottom: 0;
        right: -5px;
        padding: 5px 0;
        background: #fff;
        position: absolute;
        border-radius: 4px;
        transform: scale(0);
        transform-origin: bottom right;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.15);
        transition: transform 0.2s ease;
    }

    .notes-container .settings.show .menu {
        transform: scale(1);
    }

    .notes-container .settings .menu li {
        height: 25px;
        font-size: 16px;
        margin-bottom: 2px;
        padding: 17px 15px;
        cursor: pointer;
        box-shadow: none;
        border-radius: 0;
        justify-content: flex-start;
    }

    .notes-container .menu li:last-child {
        margin-bottom: 0;
    }

    .notes-container .menu li:hover {
        background: #f5f5f5;
    }

    .notes-container .menu li i {
        padding-right: 8px;
    }

    .note-it-color {
        color: white;
        /* Change this color to your desired color */
    }

    .header-search-box {
    padding: 20px;
    display: flex;
    align-items: center;
    justify-content: center; /* Align items to the right */
    position: ;
    top: 0;
    right: 0;
    margin: 20px; /* Add some margin to adjust the position */

    }

    .header-search-box input[type="text"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-right: 10px;
        width: 20%;
    }

    .header-search-box button {
    padding: 10px 20px;
    background-color: #6A93F8;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s; /* Add transition for smooth effect */
}

.header-search-box button:hover {
    background-color: #587fcc; /* Change background color on hover */
    
}

</style>

<body>
    <div class="header-search-box">
        <input type="text" id="searchInput" placeholder="Search...">
        <button onclick="searchNotes()">Search</button>
    </div>
    <div class="sidebar">
        <h1>Note<span class="note-it-color"><span style="font-family: 'Passion One', sans-serif;">It</span>!</span></h1>
        <ul>
            <li>
                <img src="all_notes.png" alt="All Notes Icon" class="icon">
                <a href="#">All Notes</a>
            </li>
            <li>
                <img src="favorites.png" alt="Favorites Icon" class="icon">
                <a href="#">Favorites</a>
            </li>
            <li>
                <img src="archive.png" alt="Archive Icon" class="icon">
                <a href="#">Archive</a>
            </li>
            <li>
                <img src="logout.png" alt="Logout Icon" class="icon">
                <a href="logout.php">Log out</a>
            </li>
        </ul>
        <p style="position: absolute; bottom: 20px; left: 50px; margin: 0; font-size: 20px; color: black;">Hi <?php echo $username; ?>! <br>Welcome Back.</p>
        <!-- Display the logged-in user's name -->
    </div>
    <div class="popup-box">
    <div class="popup">
        <div class="content">
            <header>
                <p>Add Note</p>
                <i class="uil uil-times"></i>
            </header>
            <form action="dashboard.php" method="post"> <!-- Updated action attribute -->
                <div class="row title">
                    <label>Title</label>
                    <input type="text" name="title" spellcheck="false"> <!-- Added name attribute -->
                </div>
                <div class="row description">
                    <label>Description</label>
                    <textarea name="description" spellcheck="false"></textarea> <!-- Added name attribute -->
                </div>
                <button type="submit" name="submit" value="Add Note">Add Note</button> <!-- Added name and value for submit button -->
            </form>
        </div>
    </div>
</div>

    <div class="wrapper">
        <li class="add-box">
            <div class="icon"><i class="uil uil-plus"></i></div>
            <p>Add Note</p> <!-- Changed "Add a new Note" to "Add Note" here -->
        </li>
    </div>
    <div class="notes-container">
        <!-- Notes will be displayed here -->
    </div>
    <script> const addBox = document.querySelector(".add-box"),
popupBox = document.querySelector(".popup-box"),
popupTitle = popupBox.querySelector("header p"),
closeIcon = popupBox.querySelector("header i"),
titleTag = popupBox.querySelector("input"),
descTag = popupBox.querySelector("textarea"),
addBtn = popupBox.querySelector("button");

const months = ["January", "February", "March", "April", "May", "June", "July",
              "August", "September", "October", "November", "December"];
let notes = JSON.parse(localStorage.getItem("notes") || "[]");
let isUpdate = false, updateId;

addBox.addEventListener("click", () => {
    popupTitle.innerText = "Add a new Note";
    addBtn.innerText = "Add Note";
    popupBox.classList.add("show");
    document.querySelector("body").style.overflow = "hidden";
    if(window.innerWidth > 660) titleTag.focus();
});

closeIcon.addEventListener("click", () => {
    isUpdate = false;
    titleTag.value = descTag.value = "";
    popupBox.classList.remove("show");
    document.querySelector("body").style.overflow = "auto";
});

function showNotes() {
    if(!notes) return;
    document.querySelectorAll(".note").forEach(li => li.remove());
    notes.forEach((note, id) => {
        let filterDesc = note.description.replaceAll("\n", '<br/>');
        let liTag = `<li class="note">
                        <div class="details">
                            <p>${note.title}</p>
                            <span>${filterDesc}</span>
                        </div>
                        <div class="bottom-content">
                            <span>${note.date}</span>
                            <div class="settings">
                                <i onclick="showMenu(this)" class="uil uil-ellipsis-h"></i>
                                <ul class="menu">
                                    <li onclick="updateNote(${id}, '${note.title}', '${filterDesc}')"><i class="uil uil-pen"></i>Edit</li>
                                    <li onclick="deleteNote(${id})"><i class="uil uil-trash"></i>Delete</li>
                                </ul>
                            </div>
                        </div>
                    </li>`;
        addBox.insertAdjacentHTML("afterend", liTag);
    });
}
showNotes();

function showMenu(elem) {
    elem.parentElement.classList.add("show");
    document.addEventListener("click", e => {
        if(e.target.tagName != "I" || e.target != elem) {
            elem.parentElement.classList.remove("show");
        }
    });
}

function deleteNote(noteId) {
    let confirmDel = confirm("Are you sure you want to delete this note?");
    if(!confirmDel) return;
    notes.splice(noteId, 1);
    localStorage.setItem("notes", JSON.stringify(notes));
    showNotes();
}

function updateNote(noteId, title, filterDesc) {
    let description = filterDesc.replaceAll('<br/>', '\r\n');
    updateId = noteId;
    isUpdate = true;
    addBox.click();
    titleTag.value = title;
    descTag.value = description;
    popupTitle.innerText = "Update a Note";
    addBtn.innerText = "Update Note";
}

addBtn.addEventListener("click", e => {
    e.preventDefault();
    let title = titleTag.value.trim(),
    description = descTag.value.trim();

    if(title || description) {
        let currentDate = new Date(),
        month = months[currentDate.getMonth()],
        day = currentDate.getDate(),
        year = currentDate.getFullYear();

        let noteInfo = {title, description, date: `${month} ${day}, ${year}`}
        if(!isUpdate) {
            notes.push(noteInfo);
        } else {
            isUpdate = false;
            notes[updateId] = noteInfo;
        }
        localStorage.setItem("notes", JSON.stringify(notes));
        showNotes();
        closeIcon.click();
    }
});

function searchNotes() {
    const searchInput = document.getElementById("searchInput").value.trim().toLowerCase();
    const filteredNotes = notes.filter(note => {
        return note.title.toLowerCase().includes(searchInput);
    });
    document.querySelectorAll(".note").forEach(li => li.remove());
    filteredNotes.forEach((note, id) => {
        let filterDesc = note.description.replaceAll("\n", '<br/>');
        let liTag = `<li class="note">
                        <div class="details">
                            <p>${note.title}</p>
                            <span>${filterDesc}</span>
                        </div>
                        <div class="bottom-content">
                            <span>${note.date}</span>
                            <div class="settings">
                                <i onclick="showMenu(this)" class="uil uil-ellipsis-h"></i>
                                <ul class="menu">
                                    <li onclick="updateNote(${id}, '${note.title}', '${filterDesc}')"><i class="uil uil-pen"></i>Edit</li>
                                    <li onclick="deleteNote(${id})"><i class="uil uil-trash"></i>Delete</li>
                                </ul>
                            </div>
                        </div>
                    </li>`;
        addBox.insertAdjacentHTML("afterend", liTag);
    });
    
}
 
</script>
</body>

</html>
