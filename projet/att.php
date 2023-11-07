<?php
$selectedPasswordType = '3caracteres';
$errorMessage = ''; // Initialisation de la variable $errorMessage
set_time_limit(3000);
if (isset($_POST['attackButton'])) {
    $selectedPasswordType = $_POST['passwordType'];
    $passwordInput = $_POST['password'];

    // Vérification du mot de passe en fonction du type sélectionné
    if ($selectedPasswordType === '3caracteres' && preg_match('/^[01]{3}$/', $passwordInput)) {
        $errorMessage = ''; // Réinitialisation de la variable en cas de succès
    } elseif ($selectedPasswordType === '5chiffres' && preg_match('/^[0-9]{5}$/', $passwordInput)) {
        $errorMessage = ''; // Réinitialisation de la variable en cas de succès
    } elseif ($selectedPasswordType === '5caracteres' && preg_match('/^[a-zA-Z0-9+*...]{5}$/', $passwordInput)) {
        $errorMessage = ''; // Réinitialisation de la variable en cas de succès
    } else {
        $errorMessage = 'Le mot de passe ne respecte pas le type sélectionné.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        display:flex;
        justify-content:space-around;
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
.submit:hover, .submit-button:focus {
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
    <h1>Attack of passwords</h1>
    <form id="passwordForm" method="post">
        <label for="passwordType">Choose the type of password:</label>
        <select id="passwordType" name="passwordType" onchange="checkPassword()" class="slct">
            <option value="3caracteres">Password of 3 caracteres (0, 1)</option>
            <option value="5chiffres">Password of 5 caracteres (0..9)</option>
            <option value="5caracteres">Password of 5 caracteres (a..z, A..Z, 0..9, +, *, ...)</option>
        </select>
        <br>

        <label for="password">Enter the password:</label>
        <input type="text" id="password" name="password" oninput="checkPassword()">
        <br>

        <p id="error-message" style="color: red"><?php echo $errorMessage; ?></p>

        <button type="submit" name="attackButton" class="submit">Attack</button>
    </form>
    <hr>
    <h2>Result:</h2>
    <?php
        if (isset($_POST['attackButton'])) {
            if ($selectedPasswordType === '3caracteres') {
                $command = "python type1.py " . escapeshellarg($passwordInput);
                $reversed_message = shell_exec($command);
                // Exécutez l'attaque pour le mot de passe de 3 caractères ici
                echo 'Launch of an attack <Password of 3 caracteres>. <br> ' . $reversed_message;
            } elseif ($selectedPasswordType === '5chiffres') {
                $command = "python type2.py " . escapeshellarg($passwordInput);
                $reversed_message = shell_exec($command);
                // Exécutez l'attaque pour le mot de passe de 5 chiffres ici
                echo 'Launch of an attack <Password of 5 caracteres>.'. $reversed_message;
            } elseif ($selectedPasswordType === '5caracteres') {
                $command = "python type3.py " . escapeshellarg($passwordInput);
                $reversed_message = shell_exec($command);
                // Exécutez l'attaque pour le mot de passe de 5 caractères spéciaux ici
                echo 'Launch of an attack <Password of 5 special caracteres>.'. $reversed_message ;
            }
        }
        ?>
        <br>
        <hr>
</section>
</body>
</html>
