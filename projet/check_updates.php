<?php
// Database connection parameters (same as in dic.php)
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'boite_crypto';

// Your code for checking updates
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
        $mysqli = new mysqli($hostname, $username, $password, $database);
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
        
        $sql = "SELECT username, password FROM users WHERE password = ?";
        $stmt = $mysqli->prepare($sql);
        
        if ($stmt === false) {
            die("Prepare failed: " . $mysqli->error);
        }
        
        $stmt->bind_param("s", $md5Password);
        
        if ($stmt->execute() === false) {
            die("Execute failed: " . $stmt->error);
        }
        
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Password match found
            $matchCount++;
            $row = $result->fetch_assoc();
            $username = $row["username"];
            $matchEndTime = microtime(true);
            $matchTime = $matchEndTime - $matchStartTime;
            echo "Match Found ($matchCount): Username: $username, Password: $md5Password, Time Taken: $matchTime seconds<br>";
        }

        // Close the database connection for this query
        $stmt->close();
        $mysqli->close();
    }

    // Close the file
    fclose($file);
} else {
    echo "Failed to open the file.";
}
?>
