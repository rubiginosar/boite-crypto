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

// Open the "mdp.txt" file for reading
$file = fopen("mdp.txt", "r");

if ($file) {
    // Loop through each line in the password file
    while (($md5Password = fgets($file)) !== false) {
        // Remove newline characters if present
        $md5Password = trim($md5Password);

        // Use a prepared statement to safely handle the password value
        $sql = "SELECT username, password FROM users WHERE password = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $md5Password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Password match found
            $row = $result->fetch_assoc();
            $username = $row["username"];
            echo "Match Found: Username: $username, Password: $md5Password\n";
        }
    }

    // Close the file
    fclose($file);
} else {
    echo "Failed to open the file.";
}

// Close the database connection
$mysqli->close();

// If no matches were found
if (!isset($username)) {
    echo "None found.\n";
}
?>
