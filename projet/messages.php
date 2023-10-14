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

    $conn = new mysqli($servername, $username, $password, $dbname);

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
            $sender = $row['sender'] === $loggedInUsername ? "You" : $row['sender'];
            $receiver = $row['receiver'] === $loggedInUsername ? "You" : $row['receiver'];

            $messageId = $row['id'];
            echo "<tr id='message_" . $messageId . "'>";
            echo "<td>" . $sender . "</td><td>" . $receiver . "</td><td>" . $row['message'] . "</td>";

            // Perform decryption in PHP
            $command = "python decrypt.py " . escapeshellarg($row['message']);

            // Execute the command and capture the output
            $decryptedMessage = shell_exec($command);
            echo "<td>" . $decryptedMessage . "</td>";

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No messages found.";
    }

    $stmt->close();
    $conn->close();
} else {
    // Handle the case when the user is not authenticated
    echo "User is not authenticated. Please log in.";
}

