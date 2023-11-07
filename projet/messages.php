<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>CryptoBox | Received</title>
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
            display:flex;
            justify-content:space-around;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
        }
        nav ul li a:hover {
            text-decoration: none;
            color: #2980b9;
        }
        nav ul li a:focus {
            text-decoration: none;
            color: #8e44ad;
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

        select {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }


        
      .slct {
  width: 100%;
  padding: 10px;
  border: 1px solid #2980b9;
  background-color: #2980b9;
  color: #fff;
  border-radius: 5px;
  appearance: none;
  cursor: pointer;
}

/* Style the select arrow */
.slct::after {
  content: "\25BC"; /* Down arrow character */
  position: absolute;
  top: 50%;
  right: 10px;
  transform: translateY(-50%);
  color: #8e44ad;
}

/* Style select options */
.slct option {
  background-color: #fff;
  color: #2980b9;
}

/* Style select on hover/focus */
.slct:hover,
.select-element:focus {
  background-color: #8e44ad;
  border-color: #8e44ad;
}
      /* Style the submit button */
.submit {
  padding: 10px 20px; /* Adjust padding as needed */
  background-color: #2980b9;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-top:50px;
}

/* Style the submit button on hover/focus */
.submit:hover, .submit-button:focus {
  background-color: #8e44ad;
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
            <li><a href="./att.php">Password</a></li>
            <li><a href="./stegano.php">Steganographie</a></li>
            <li><a href="./logout.php">Logout</a></li>
        </ul>
    </nav>
</header>
<section id="receive">
    <h1>Receive Messages</h1>
    <form method="POST">
        <!-- Select a message to decrypt -->
        <label for="messageSelect">Select a Message to Decrypt:</label>
        <select id="messageSelect" name="messageSelect" class="slct">
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

            // Retrieve messages from the database and populate the select dropdown
            $sql = "SELECT id, message FROM messages";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value="' . $row["message"] . '">' . $row["message"] . '</option>';
                }
            }
            $conn->close();
            ?>
        </select>
        <!-- Select decryption method -->
        <label for="decryptionMethod">Select Decryption Method:</label>
        <select id="decryptionMethod" name="decryptionMethod" class="slct">
            <option value="shift Left">Shift Left</option>
            <option value="shift Right">Shift Right</option>
            <option value="mirror">Mirror</option>
            <option value="affine">Affine</option>
            <option value="caesar">Caesar</option>
        </select>

        <!-- Decrypt button -->
        <input type="submit" name="decryptButton" value="Decrypt" class="submit">
    </form>
    <hr>
    <?php
$decryptedMessage = ""; // Initialize the variable

//session_start();

// Database connection setup (replace with your own database connection code)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "boite_crypto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['decryptButton'])) {
        $selectedMessage = $_POST['messageSelect'];
        $selectedMethod = $_POST['decryptionMethod'];

        // Database connection setup 
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "boite_crypto";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Initialize a flag to track if the message format is correct
        $validMessageFormat = false;

        switch ($selectedMethod) {
            case "shift Left":
                if (strpos($selectedMessage, "L_") === 0) {
                    $validMessageFormat = true;
                    // Remove the "L_" prefix
                    $selectedMessage = substr($selectedMessage, 2);
                    $command = "python right.py " . escapeshellarg($selectedMessage);
                    // Capture the output of the Python script
                    $decryptedMessage = shell_exec($command);
                    if ($decryptedMessage !== null) {
                        $decryptedMessage = substr($decryptedMessage, 2);
                    }
                }
                break;
            case "shift Right":
                if (strpos($selectedMessage, "R_") === 0) {
                    $validMessageFormat = true;
                    // Remove the "R_" prefix
                    $selectedMessage = substr($selectedMessage, 2);
                    $command = "python left.py " . escapeshellarg($selectedMessage);
                    // Capture the output of the Python script
                    $decryptedMessage = shell_exec($command);
                    if ($decryptedMessage !== null) {
                        $decryptedMessage = substr($decryptedMessage, 2);
                    }
                }
                break;
                case "mirror":
                    $validMessageFormat = true;
                    $command = "python mirror.py " . escapeshellarg($selectedMessage);
                    // Capture the output of the Python script
                    $decryptedMessage = shell_exec($command);
                    break;                           
            case "affine":
                if (strpos($selectedMessage, "A_") === 0) {
                    $validMessageFormat = true;
                    // Remove the "A_" prefix
                    $selectedMessage = substr($selectedMessage, 2);
                    $command = "python decrypt.py " . escapeshellarg($selectedMessage);
                    // Capture the output of the Python script
                    $decryptedMessage = shell_exec($command);
                }
                break;
            case "caesar":
                if (strpos($selectedMessage, "C_") === 0) {
                  $validMessageFormat = true;
                    // Remove the "C_" prefix
                    $selectedMessage = substr($selectedMessage, 2);
                    $command = "python dcaesar.py " . escapeshellarg($selectedMessage);
                    // Capture the output of the Python script
                    $decryptedMessage = shell_exec($command);
                    // Implement your caesar decryption logic here
              //  }
                }
                break;
            default: 
                $decryptedMessage = "Invalid decryption method selected";
        }

        // Display the decrypted message (or an empty string if not decrypted)
        $decryptedMessage = isset($decryptedMessage) ? $decryptedMessage : "";

        // Close the database connection
        if (isset($stmt)) {
            $stmt->close();
        }
        $conn->close();
    }
}
?>



    <!-- Display the decrypted message -->
    <h2>Decrypted Message:</h2>
    <p><?php echo $decryptedMessage; ?></p>
    
    <hr>
</section>
</body>
</html>
