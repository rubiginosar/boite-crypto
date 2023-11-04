<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div  alt="" class="fond" >
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

<?php
session_start();

// Database connection setup (replace with your own database connection code)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "boite_crypto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        // Get the username and password from the login form
        $username = $_POST["username"];
        $enteredPassword = $_POST["password"];

        // Check if the user exists in the database
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row["password"];

            // Verify the entered password against the hashed password in the database
            if (password_verify($enteredPassword, $hashedPassword)) {
                // Passwords match, so store the username in a session variable
                $_SESSION['authenticatedUsername'] = $username;

                // Redirect to the home page upon successful login
                header("Location: mailbox.php");
                exit();
            } else {
                // Passwords don't match, display an error message
                echo "Invalid password. Please try again.";
            }
        } else {
            // User doesn't exist, display an error message or redirect to the registration page
            echo "Invalid username. Please register or try again.";
        }
    }
}

$conn->close();
?>
