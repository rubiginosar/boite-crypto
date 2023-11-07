<?php

// Include a ban checking function
require("ban.php");
check_if_banned();

// Check if the HTML form was submitted
if (count($_POST) > 0) {
    $databaseHost = "localhost";
    $databaseName = "boite_crypto"; // Replace with your actual database name
    $databaseUser = "root";
    $databasePassword = "";

    // Create a DSN (Data Source Name) for database connection
    $dsn = "mysql:host=$databaseHost;dbname=$databaseName";

    try {
        // Try to establish a database connection using PDO
        $db = new PDO($dsn, $databaseUser, $databasePassword);
    } catch (PDOException $e) {
        // Handle connection errors
        die("Could not connect: " . $e->getMessage());
    }

    // Check if the "Register" button was clicked
    if (isset($_POST['register'])) {
        // Redirect to the registration page
        header("Location: register.php");
        die;
    } else {
        // Query the database to find a user by their username
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stm = $db->prepare($query);

        if ($stm) {
            // Execute the query, binding the provided username
            $stm->execute([
                'username' => $_POST['username'],
            ]);
            
            // Fetch the user data
            $row = $stm->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                // Verify the entered password against the hashed password in the database
                if (password_verify($_POST['password'], $row['password'])) {
                    // Passwords match, user is authenticated
                    check_if_banned(true, true);
                    header("Location: mailbox.php");
                    die;
                }
            }
        }

        // If the username or password doesn't match, display a failure message
        echo "Failed";
        check_if_banned(true, false);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css"> <!-- Include your CSS file here -->
</head>
<body>
<div alt="" class="fond" >
    <div class="center">
        <h1>Login</h1>
        <form method="post" action="login.php">
            <div class="txt_field">
                <span></span>
                <input type="text" id="username" name="username" required><br>
                <label for="username">Username:</label>
            </div>
            <div class="txt_field">
                <span></span>
                <input type="password" id="password" name="password" required><br>
                <label for="password">Password:</label>
            </div>
            <input type="submit" value="Login">
        </form>
        <div id="registration-container">
            <form action="./register.php" method="post" >
                <input type="submit" value="Register">
            </form>
        </div>
    </div>  
</div>  
    

    
</body>
</html>
