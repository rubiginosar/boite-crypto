<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedUser = $_POST["userSelect"];
    $encryptionType = $_POST["encryptionType"];
    $messageContent = $_POST["messageContent"];
    $keyA="";
    $keyB= "";

    // Check if the user is logged in and the session has an authenticated username
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

        // Handle the message encryption based on the selected encryption type
        // if ($encryptionType === "mirror") {
        //     // Define the shell command to call the Python script (replace with your script)
        //     $command = "python mirror.py " . escapeshellarg($messageContent);

        //     // Execute the command and capture the output
        //     $reversed_message = shell_exec($command);

        //     // // Check if the message is a palindrome and remove leading "00"
        //     // if (substr($reversed_message, 0, 2) === "00") {
        //     //     $reversed_message = substr($reversed_message, 2);
        //     // }
        // }
// ...

switch ($encryptionType) {
    case "mirror":
        $command = "python mirror.py " . escapeshellarg($messageContent);
        $reversed_message = shell_exec($command);
        break;
    case "affine":
        $keyA = $_POST["keyA"];
        $keyB = $_POST["keyB"];
        $command = "python affine.py " . escapeshellarg($keyA) . " " . escapeshellarg($keyB) . " " . escapeshellarg($messageContent);
        $reversed_message = shell_exec($command);
        if (trim($reversed_message) === "error") {
            header("Location: home.php");
            exit(); // Exit to prevent saving an empty message
        }
        break;
        case "shift":
            // Récupérer la valeur (left ou right) depuis home.php
         $shiftDirection = $_POST["shiftDirection"];
         // Vérifier la direction du décalage
         if ($shiftDirection === "left") {
             $command = "python left.py " . escapeshellarg($messageContent);
         } elseif ($shiftDirection === "right") {
             $command = "python right.py " . escapeshellarg($messageContent);
         } 
         // Exécuter le script Python pour le décalage
         $reversed_message = shell_exec($command);
         if (trim($reversed_message) === "error") {
             header("Location: home.php");
             exit(); // Exit pour éviter d'enregistrer un message vide
         }
         break;
}

// Check if $reversed_message is not empty and not equal to an empty string
// Check if $reversed_message is not empty and not equal to an empty string
if (!empty($reversed_message) && trim($reversed_message) !== "") {
    // Proceed with saving the message
    $sql = "INSERT INTO messages (sender, receiver, message, A, B) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $loggedInUsername, $selectedUser, $reversed_message, $keyA, $keyB);

    // Execute the SQL query to insert the message into the database
    if ($stmt->execute()) {
        echo "Message sent successfully.";
        header("Location: home.php");
    } else {
        echo "Error sending the message: " . $stmt->error;
    }
} else {
    header("Location: home.php");
    // Optionally, you can display an error message to the user if needed
}


// ...


        // Close the prepared statement and the database connection
        $stmt->close();
        $conn->close();
    } else {
        echo "User is not authenticated. Please log in.";
    }
} else {
    echo "Form not submitted.";
}
?>
