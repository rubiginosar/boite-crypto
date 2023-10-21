<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
</head>
<body>
    <h2>Registration</h2>
    <form method="post" action="register.php">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>

<?php
// Database connection setup (replace with your own database connection code)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "boite_crypto";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the database connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    
    if (preg_match('/^[01]{3}$/', $password) || preg_match('/^[0-9]{5}$/', $password) || preg_match('/^[A-Za-z0-9+*...]{5}$/', $password)) {
        // Check if the username is already in use
        $checkSql = "SELECT * FROM users WHERE username = '$username'";
        $checkResult = $conn->query($checkSql);
    
        if ($checkResult->num_rows > 0) {
            // Display an error message if the username is already in use
            echo "Username is already in use. Please choose another.";
        } elseif ($password !== $confirm_password) {
            // Display an error message if passwords do not match
            echo "Passwords do not match. Please try again.";
        } else {
            // Insert the new user into the database
            $insertSql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
            
            // Check if the user was successfully inserted
            if ($conn->query($insertSql) === TRUE) {
                // Registration successful; redirect to the home page
                echo "Registration successful!";
                header("Location: home.php");
                exit();
            } else {
                // Display an error message if there was a database error
                echo "Error: " . $insertSql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Invalid password. Password should meet the criteria.";
    }
    
    // Close the database connection
    $conn->close();
}
?>
