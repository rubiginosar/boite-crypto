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
      form {
        display:flex;
        justify-content:space-around;
        }
      .submit {
          font-size:20px;
          padding: 10px 10px; /* Adjust padding as needed */
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
          <li><a href="./logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>
</body>
</html>
<?php

// Database connection parameters
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'boite_crypto';

// Open a connection to the database
$mysqli = new mysqli($hostname, $username, $password, $database);

// Check for a connection error
if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Set a maximum execution time for your script (in seconds)
$maxExecutionTime = 55;  // Set a value that is slightly below the PHP max_execution_time

// Get the start time
$startTime = time();

echo '<div id="output">'; // Start the output container

// Define a variable to indicate the type of attack (dictionary or brute force)
$attackType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if either button is clicked
    if (isset($_POST["dictionaryAttack"])) {
        $attackType = "dictionary";
    } elseif (isset($_POST["bruteForceAttack"])) {
        $attackType = "bruteforce";
    }
}

// Check the type of attack and execute the appropriate logic
if ($attackType === "dictionary" || $attackType === "bruteforce") {
    // Open the "mdp.txt" file for reading
    $file = fopen("mdp.txt", "r");

    if ($file) {
        $matchCount = 0;

        // Loop through each line in the password file
        while (($md5Password = fgets($file)) !== false) {
            // Remove newline characters if present
            $md5Password = trim($md5Password);

            // Check the remaining execution time
            $remainingTime = $maxExecutionTime - (time() - $startTime);

            // If there's not enough remaining time, exit the script
            if ($remainingTime < 5) {  // Set a safe margin for exiting (e.g., 5 seconds)
                break;
            }

            // Start the timer for this match
            $matchStartTime = microtime(true);

            // Use a prepared statement to safely handle the password value
            $sql = "SELECT username, password FROM users WHERE password = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $md5Password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Password match found
                $matchCount++;
                $row = $result->fetch_assoc();
                $username = $row["username"];
                $matchEndTime = microtime(true);
                $matchTime = $matchEndTime - $matchStartTime;
                echo "Match Found ($matchCount): Username: $username, Password: $md5Password, Time Taken: $matchTime seconds<br>";
                // Flush the output buffer to display immediately
                ob_flush();
                flush();
            }
        }

        // Close the file
        fclose($file);
    } else {
        echo "Failed to open the file.";
    }
}

echo '</div>'; // End the output container

// Close the database connection
$mysqli->close();

// If no matches were found
if (!isset($username)) {
    echo "None found.\n";
}
?>

<form method="post">
    <button type="submit" name="dictionaryAttack" class="submit">Attack by Dictionary</button>
    <button type="submit" name="bruteForceAttack" class="submit">Attack by Brute Force</button>
</form>
