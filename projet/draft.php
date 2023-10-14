<?php
session_start(); // Start the session

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input
    $selectedUser = $_POST["userSelect"]; // This should be the recipient, not the sender
    $encryptionType = $_POST["encryptionType"];
    $messageContent = $_POST["messageContent"];

    // Check if the user is authenticated
    if (isset($_SESSION['authenticatedUsername'])) {
        // The user is authenticated
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

        // If encryption type is "mirror," reverse the message using Python
        if ($encryptionType === "mirror") {
            // Define the shell command to call the Python script
            $command = shell_exec("python mirror.py".$messageContent);
            print_r($command);
            
            // Execute the command and capture the output
            $reversed_message = $command;
            echo $reversed_message;
            // Check if the message is a palindrome and remove leading "00"
            if (substr($reversed_message, 0, 2) === "00") {
                $reversed_message = substr($reversed_message, 2);
            }
        }

        // Insert the reversed message into the database (replace with your table and column names)
        $sql = "INSERT INTO messages (sender, receiver, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $loggedInUsername, $selectedUser, $reversed_message);

        if ($stmt->execute()) {
            echo "Message sent successfully.";
        } else {
            echo "Error sending the message: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        // Handle the case when the user is not authenticated
        echo "User is not authenticated. Please log in.";
    }
} else {
    // Handle the case when the form is not submitted
    echo "Form not submitted.";
}
?>