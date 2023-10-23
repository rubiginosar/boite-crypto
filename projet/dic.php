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

echo '</div>'; // End the output container

// Close the database connection
$mysqli->close();

// If no matches were found
if (!isset($username)) {
    echo "None found.\n";
}
?>
