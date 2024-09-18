<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alfa+Slab+One&family=Passion+One:wght@400;700;900&display=swap" rel="stylesheet">
    <title>NoteIt!</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Additional styles specific to this HTML */
        body {
            font-family: Arial, sans-serif;
            background-image: linear-gradient(120deg, #a1c4fd 0%, #c2e9fb 100%);
            background-position: center;
            height: 100vh;
            background-size: cover; /* Cover the entire background */
            background-repeat: no-repeat; /* Prevent background image from repeating */
            margin: 0;
            padding: 0;
            background-color: #15202b;
        }

        /* Navbar Styles */
        .navbar {
            background-color: none; /* Changed background color to white */
            color: #005689; /* Changed text color to black */
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-title {
            margin-left: 20px;
            font-size: 50px;
            font-weight: bold;
            font-family: "Passion One", sans-serif;
        }

        .navbar-title .black {
            color: #fb8500; /* Changed color of "Note" to black */
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
            color: black; /* Changed link color to black */
            transition: color 0.3s; /* Added transition effect for color change */
            padding: 15px 15px; /* Adjust padding for better spacing */
}
        

        /* Hover effect */
        .navbar ul li a:hover {
    color: #fb8500; /* Change text color on hover */
   background-color: #d5eeff; 
    border-radius: 10px;

}

        

        /* Body Styles */
        .container {
            display: flex;
            justify-content: center; /* Center the items horizontally */
            align-items: center; /* Center the items vertically */
            margin-top: 10px;
        }

        .left-div {
            flex: 1;
            text-align: center;
            padding-right: 10px; /* Adjusted padding */
            margin-right: 5px; /* Adjusted margin */
        }

        .left-div img {
            width: 100%; /* Enlarge the image to fill the container */
            max-width: 600px; /* Limit the maximum width of the image */
            height: auto;
            border-radius: 50px;
        }

        .right-div {
  flex: 1; /* Maintain the original width */
  background: 0 0 0 / 0%;
  color: black;
  position: relative;
  border-radius: 2.5em;
  padding: 2em;
  transition: transform 0.4s ease;
  text-align: center;

}


        .blur-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #fffffc; /* Added background color with transparency */
            backdrop-filter: blur(10px); /* Apply blur effect */
            border-radius: 50px; /* Added border-radius for rounded corners */
            z-index: -1; /* Push behind other elements */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);       
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .paragraph-container {
            max-width: 600px; /* Enlarge the paragraph container */
            margin: 0 auto;
            position: relative; /* Add position relative for z-index */
            z-index: 1; /* Ensure the text appears above the blurred background */
        }

        .paragraph-container h1 {
            color: #005689; /* Green color for "It" */
            margin-bottom: 20px;
            font-size: 70px; /* Increase the font size of the heading */
            font-family: "Passion One", sans-serif;
        }

        .paragraph-container h1 .green {
            color: #fb8500; /* Keep "It" green */
        }

        .paragraph-container p {
            color: black;
            line-height: 1.6;
            font-size: 20px; /* Increase the font size of the paragraph */
            text-align: center; /* Justify the paragraph text */
        }

        .button {
            cursor: pointer;
            position: relative;
            padding: 10px 24px;
            font-size: 18px;
            color: white;
            border: 2px solid #fb8500;
            border-radius: 34px;
            background-color: #fb8500;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            overflow: hidden;
            z-index: 1;
            margin-top: 20px;
            margin-bottom: 20px;
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
            background-color: #d00000;
            transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
            
        }

        .button:hover::before {
            transform: scale(3);
        }

        .button:hover {
            color: white;
            transform: scale(1.1);
            box-shadow: 0 0px 20px rgba(193, 163, 98, 0.4);
        }

        .button:active {
            transform: scale(1);
        }

        /* Responsive adjustments */
        @media screen and (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left-div,
            .right-div {
                padding: 0 10px; /* Adjusted padding */
                margin: 0 0 10px 0; /* Adjusted margin */
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-title">Note<span class="black">It!</span></div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="register.php">Sign Up</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
    </nav>

    <!-- Body -->
    <div class="container">
        <!-- Left Div with Photo/Logo -->
        <div class="left-div">
            <img src="inde.png" alt="Logo">
        </div>

        <!-- Right Div with Paragraph -->
        <div class="right-div">
            <div class="blur-background"></div> <!-- Added element for background blur -->
            <div class="paragraph-container">
                <h1>Note<span class="green">It!</span></h1>
                <p>NoteIt! makes it easy to collaborate on projects. Real-Time Editing immediately syncs changes to keep all contributors up to date. The Tasks feature helps you outline the next steps and assign responsibilities. And with unlimited sharing permissions, everyone is the loop and on the same page. Store all notes and important information digitally, usually in a cloud-based storage system.
Type, write, and draw notes on the device of choice just as one would using pen and paper.
</p>
            </div>
            <button class="button" id="signUpButton">Sign Up</button>
        </div>
    </div>
    <script>
        // JavaScript to make the Sign Up button functional
        document.getElementById("signUpButton").addEventListener("click", function() {
            window.location.href = "register.php";
        });
    </script>
</body>
</html>
