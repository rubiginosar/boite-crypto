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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Attack of passwords</title>
    <style>
      @import url("https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap");
      body {
        font-family: "Poppins", sans-serif;
        background-color: #f2f2f2;
        margin: 0;
        padding: 0;
        margin-top: 80px;
      }

      header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-color: #333;
        color: #fff;
        padding: 10px;
        z-index: 100;
      }

      nav ul {
        list-style: none;
        padding: 0;
        position: sticky;
        display: flex;
        justify-content: space-around;
      }

      nav ul li {
        display: inline;
        margin-right: 20px;
      }

      nav ul li a {
        text-decoration: none;
        color: #fff;
      }
      nav ul li a:hover {
        text-decoration: none;
        color: #2980b9;
      }
      nav ul li a:focus {
        text-decoration: none;
        color: #8e44ad;
      }
      section {
        background-color: #fff;
        margin: 20px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
      }

      h1 {
        font-size: 24px;
        margin: 0 0 10px 0;
      }
      .slct {
        width: 100%;
        padding: 10px;
        border: 1px solid #2980b9;
        background-color: #2980b9;
        color: #fff;
        border-radius: 5px;
        appearance: none;
        cursor: pointer;
      }

      /* Style the select arrow */
      .slct::after {
        content: "\25BC"; /* Down arrow character */
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        color: #8e44ad;
      }

      /* Style select options */
      .slct option {
        background-color: #fff;
        color: #2980b9;
      }

      /* Style select on hover/focus */
      .slct:hover,
      .select-element:focus {
        background-color: #8e44ad;
        border-color: #8e44ad;
      }

      label {
        display: block;
        font-weight: bold;
      }

      input[type="text"],
      textarea {
        width: 100%;
        padding: 10px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 5px;
      }

      input[type="submit"] {
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }

      input[type="submit"]:hover {
        background-color: #555;
      }
      /* Style the submit button */
      .submit {
        padding: 10px 20px; /* Adjust padding as needed */
        background-color: #2980b9;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
      }

      /* Style the submit button on hover/focus */
      .submit:hover,
      .submit-button:focus {
        background-color: #8e44ad;
      }
    </style>
  </head>
  <body>
    <header>
      <nav>
        <ul>
          <li><a href="./mailbox.php">Home</a></li>
          <li><a href="./home.php">Send Message</a></li>
          <li><a href="./messages.php">Receive Message</a></li>
          <li><a href="./dic.php">Attack</a></li>
          <li><a href="./att.php">Password</a></li>
          <li><a href="./stegano.php">Steganographie</a></li>
          <li><a href="./logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>
    <section>
      <h1>Attack Force Brute</h1>
      <form id="passwordForm" method="post">
        <p id="error-message" style="color: red">
          <?php echo $errorMessage; ?>
        </p>
        <label for="username">Nom d'utilisateur:</label>
        <input type="text" id="username" name="username" required />
        <button type="submit" name="attackButton" class="submit">Attack</button>
      </form>
    </section>
  </body>
</html>
