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
        $password = $_POST["password"];

        // Check if the user exists in the database
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User exists, so store the username in a session variable
            $_SESSION['authenticatedUsername'] = $username;

            // Redirect to the home page upon successful login
            header("Location: home.php");
            exit();
        } else {
            // User doesn't exist, display an error message or redirect to the registration page
            echo "Invalid username or password. Please register or try again.";
        }
    }
}

$conn->close();
?>
