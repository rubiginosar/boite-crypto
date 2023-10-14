<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
</head>
<body>
    <h1>Welcome to Your Homepage</h1>
    <form id="encryptionForm" action="process.php" method="post">
        <h2>Select a User:</h2>
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

            // Retrieve users from the database
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
        <h1>Select Encryption Type:</h1>
        <select id="encryptionType" name="encryptionType" onchange="showInputFields()">
            <option value="shift">Shift</option>
            <option value="mirror">Mirror</option>
            <option value="affine">Affine</option>
            <option value="caesar">Caesar</option>
        </select>
        <div id="shiftDirection" style="display: none">
            <p>Choose Shift Direction:</p>
            <label for="shiftLeft">Left<input type="radio" id="shiftLeft" name="shiftDirection" value="left"></label>
            <label for="shiftRight">Right<input type="radio" id="shiftRight" name="shiftDirection" value="right"></label>
        </div>
        <div id="affineKeys" style="display: none">
            <p>Enter Two Affine Keys:</p>
            <label for="keyA">Key A: <input type="text" id="keyA" name="keyA"></label>
            <label for="keyB">Key B: <input type="text" id="keyB" name="keyB"></label>
        </div>
        <div id="caesarDirection" style="display: none">
            <p>Choose Caesar Direction:</p>
            <label for="caesarEncrypt">Left<input type="radio" id="caesarEncrypt" name="caesarDirection" value="encrypt"></label>
            <label for="caesarDecrypt">Right<input type="radio" id="caesarDecrypt" name="caesarDirection" value="decrypt"></label>
            <p>Enter Caesar Key:</p>
            <input type="text" id="caesarKey" name="caesarKey">
        </div>
        <h2>Compose Message:</h2>
        <textarea id="messageContent" name="messageContent" rows="4" cols="50"></textarea>
        <button type="submit">Send Message</button>
    </form>
    <script>
        function showInputFields() {
            const selectedEncryption = document.getElementById("encryptionType").value;
            const shiftDirection = document.getElementById("shiftDirection");
            const affineKeys = document.getElementById("affineKeys");
            const caesarDirection = document.getElementById("caesarDirection");

            shiftDirection.style.display = "none";
            affineKeys.style.display = "none";
            caesarDirection.style.display = "none";

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
