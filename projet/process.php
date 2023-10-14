<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedUser = $_POST["userSelect"];
    $encryptionType = $_POST["encryptionType"];
    $messageContent = $_POST["messageContent"];

    if (isset($_SESSION['authenticatedUsername'])) {
        $loggedInUsername = $_SESSION['authenticatedUsername'];

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "boite_crypto";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($encryptionType === "mirror") {
            // Define the shell command to call the Python script
            $command = "python mirror.py " . escapeshellarg($messageContent);

            // Execute the command and capture the output
            $reversed_message = shell_exec($command);

            // Check if the message is a palindrome and remove leading "00"
            if (substr($reversed_message, 0, 2) === "00") {
                $reversed_message = substr($reversed_message, 2);
            }
        }

        // Check if $reversed_message is not empty
        if (!empty($reversed_message)) {
            $sql = "INSERT INTO messages (sender, receiver, message) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $loggedInUsername, $selectedUser, $reversed_message);

            if ($stmt->execute()) {
                echo "Message sent successfully.";
            } else {
                echo "Error sending the message: " . $stmt->error;
            }
        } else {
            echo "Error: The Python script did not produce a valid message.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "User is not authenticated. Please log in.";
    }
} else {
    echo "Form not submitted.";
}

?>
