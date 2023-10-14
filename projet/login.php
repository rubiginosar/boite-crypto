<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
    <div id="registration-container">
        <form action="register.php" method="post">
            <input type="submit" value="Register">
        </form>
    </div>
</body>
</html>

<?php
session_start();


$authenticatedUsername = $_POST["username"]; // Replace with the username

// Store user information in the session
$_SESSION['authenticatedUsername'] = $authenticatedUsername;

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
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the user exists in the database
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, so redirect to the home page
        header("Location: home.php");
        exit();
    } else {
        // User doesn't exist, redirect to the registration page
        echo "please register";
        exit();
    }
}

$conn->close();
?>
