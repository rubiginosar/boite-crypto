<?php
session_start(); // Start the session

// Check if the user is authenticated
if (isset($_SESSION['authenticatedUsername'])) {
    $loggedInUsername = $_SESSION['authenticatedUsername'];

    // Database connection setup (replace with your own database connection code)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "boite_crypto";

    // Create a new MySQLi database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the database connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve messages for the logged-in user
    $sql = "SELECT id, sender, receiver, message FROM messages WHERE sender = ? OR receiver = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $loggedInUsername, $loggedInUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<h1>Your Messages</h1>";

    if ($result->num_rows > 0) {
        echo "<table border='1'><tr><th>Sender</th><th>Receiver</th><th>Message</th><th>Decrypted</th></tr>";

        while ($row = $result->fetch_assoc()) {
            // Determine if the message is from the logged-in user or another user
            $sender = $row['sender'] === $loggedInUsername ? "You" : $row['sender'];
            $receiver = $row['receiver'] === $loggedInUsername ? "You" : $row['receiver'];

            // Extract the message ID
            $messageId = $row['id'];

            // Start a new table row for the message
            echo "<tr id='message_" . $messageId . "'>";
            echo "<td>" . $sender . "</td><td>" . $receiver . "</td><td>" . $row['message'] . "</td>";

            // Perform decryption in PHP (you should replace this with actual decryption logic)
            $command = "python mirror.py " . escapeshellarg($row['message']);
            // Execute the Python script for decryption and capture the output
            $decryptedMessage = shell_exec($command);
            echo "<td>" . $decryptedMessage . "</td>";

            echo "</tr>"; // Close the table row for the message
        }

        echo "</table>"; // Close the table
    } else {
        echo "No messages found.";
    }

    $stmt->close(); // Close the prepared statement
    $conn->close(); // Close the database connection
} else {
    // Handle the case when the user is not authenticated
    echo "User is not authenticated. Please log in.";
}
?>
