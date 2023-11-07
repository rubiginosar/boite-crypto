<?php
$errorMessage = ''; // Initialize the error message variable
set_time_limit(3000);

if (isset($_POST['attackButton'])) {
    // Establish a database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "boite_crypto";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the username from the form
    $username = $_POST['username'];

    // Fetch the password from the database based on the username
    $sql = "SELECT password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($passwordFromDB);
        $stmt->fetch();

        // Execute the appropriate Python script for the password attack
        if (strlen($passwordFromDB) === 3 && preg_match('/^[01]{3}$/', $passwordFromDB)) {
            $command = "python type1.py " . escapeshellarg($passwordFromDB);
        } elseif (strlen($passwordFromDB) === 5 && preg_match('/^[0-9]{5}$/', $passwordFromDB)) {
            $command = "python type2.py " . escapeshellarg($passwordFromDB);
        } elseif (strlen($passwordFromDB) === 5 && preg_match('/^[a-zA-Z0-9+*...]{5}$/', $passwordFromDB)) {
            $command = "python type3.py " . escapeshellarg($passwordFromDB);
        }

        $reversed_message = shell_exec($command);
        echo 'Lancement de l\'attaque pour le mot de passe récupéré de la base de données. Résultat : ' . $reversed_message;
    } else {
        $errorMessage = 'Utilisateur non trouvé dans la base de données.';
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... (same as before) -->
</head>
<body>
    <h1>Attaque de Mot de passe</h1>
    <form id="passwordForm" method="post">
        <p id="error-message" style="color: red"><?php echo $errorMessage; ?></p>
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required>
        <button type="submit" name="attackButton">Attaquer</button>
    </form>
</body>
</html>
