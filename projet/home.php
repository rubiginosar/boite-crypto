<!DOCTYPE html>
<html>
<head>
    <title>CryptoBox | Mailbox</title>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap");
      body {
        font-family: "Poppins", sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
        margin-top: 80px;
      }

      header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: #333;
        color: #fff;
        padding: 10px;
        z-index: 100;
      }

      nav ul {
        list-style: none;
        padding: 0;
        position: sticky;
      }

      nav ul li {
        display: inline;
        margin-right: 20px;
      }

      nav ul li a {
        text-decoration: none;
        color: #fff;
      }
      section {
        background-color: #fff;
        margin: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
      }

      h1 {
        font-size: 24px;
        margin: 0 0 10px 0;
      }

      label {
        display: block;
        font-weight: bold;
      }

      input[type="text"],
      textarea {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
      }

      input[type="submit"] {
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }

      input[type="submit"]:hover {
        background-color: #555;
      }
    </style>
</head>
<body>
<header>
      <nav>
        <ul>
          <li><a href="./mailbox.php">Home</a></li>
          <li><a href="./home.php">Send Message</a></li>
          <li><a href="./messages.php">Receive Message</a></li>
          <li><a href="./dic.php">Attack</a></li>
          <li><a href="./logout.html">Logout</a></li>
        </ul>
      </nav>
    </header>
    <section id="send">
    <form id="encryptionForm" action="process.php" method="post">
        <!-- Select a User -->
        <label for="userSelect">Select a User:</label>
        <select id="userSelect" name="userSelect">
            <?php
            // Database connection setup (replace with your own database connection code)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "boite_crypto";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve users from the database and populate the select dropdown
            $sql = "SELECT id, username FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["username"] . '">' . $row["username"] . '</option>';
                }
            }
            $conn->close();
            ?>
        </select>
        <!-- Select Encryption Type -->
        <h1>Select Encryption Type:</h1>
        <select id="encryptionType" name="encryptionType" onchange="showInputFields()">
            <option value="shift">Shift</option>
            <option value="mirror">Mirror</option>
            <option value="affine">Affine</option>
            <option value="caesar">Caesar</option>
        </select>
        <!-- Shift Direction Input -->
        <div id="shiftDirection" style="display: none">
            <p>Choose Shift Direction:</p>
            <label for="shiftLeft">Left<input type="radio" id="shiftLeft" name="shiftDirection" value="left"></label>
            <label for="shiftRight">Right<input type="radio" id="shiftRight" name="shiftDirection" value="right"></label>
        </div>
        <!-- Affine Keys Input -->
        <div id="affineKeys" style="display: none">
            <p>Enter Two Affine Keys:</p>
            <label for="keyA">Key A: <input type="text" id="keyA" name="keyA"></label>
            <label for="keyB">Key B: <input type="text" id="keyB" name="keyB"></label>
        </div>
        <!-- Caesar Direction Input -->
        <div id="caesarDirection" style="display: none">
            <p>Choose Caesar Direction:</p>
            <label for="caesarEncrypt">Left<input type="radio" id="caesarEncrypt" name="caesarDirection" value="encrypt"></label>
            <label for "caesarDecrypt">Right<input type="radio" id="caesarDecrypt" name="caesarDirection" value="decrypt"></label>
            <p>Enter Caesar Key:</p>
            <input type="text" id="caesarKey" name="caesarKey">
        </div>
        <!-- Compose Message Textarea -->
        <h2>Compose Message:</h2>
        <textarea id="messageContent" name="messageContent" rows="4" cols="50"></textarea>
        <!-- Submit Button -->
        <button type="submit">Send Message</button>
    </form>
    <script>
        // Function to show the input fields based on the selected encryption type
        function showInputFields() {
            const selectedEncryption = document.getElementById("encryptionType").value;
            const shiftDirection = document.getElementById("shiftDirection");
            const affineKeys = document.getElementById("affineKeys");
            const caesarDirection = document.getElementById("caesarDirection");

            // Hide all input fields by default
            shiftDirection.style.display = "none";
            affineKeys.style.display = "none";
            caesarDirection.style.display = "none";

            // Display the relevant input fields based on the selected encryption type
            if (selectedEncryption === "shift") {
                shiftDirection.style.display = "block";
            } else if (selectedEncryption === "affine") {
                affineKeys.style.display = "block";
            } else if (selectedEncryption === "caesar") {
                caesarDirection.style.display = "block";
            }
        }

        showInputFields(); // Initial call to display the correct input fields
    </script>
</body>
</html>
