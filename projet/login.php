<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Database connection setup (replace with your own database connection code)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "boite_crypto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, so redirect to the home page
        $_SESSION['authenticatedUsername'] = $username;
        header("Location: home.php");
        exit();
    } else {
        // User doesn't exist, redirect to the registration page or show an error message
        echo "Please register or check your login credentials.";
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>

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
