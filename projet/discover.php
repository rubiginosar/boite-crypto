<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descover mesage</title>
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
          <li><a href="./stegano.php">Steganographie</a></li>
          <li><a href="./logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>
    <section>

        <?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_discover"])) {
// Gérer le processus de découverte de l'image ici
    // Récupérer le fichier d'image de découverte depuis le formulaire
    $discoveryImageFile = $_FILES["discovery_image"]["tmp_name"];

 // Assurez-vous que le répertoire temporaire utilisé par PHP a des permissions d'écriture
    $tmpDir = 'C:/xampp/tmp/';
// Vérifier si le répertoire temporaire a des permissions d'écriture
    if (!is_writable($tmpDir)) {
        echo 'Error: The temporary directory does not have write permissions.';
        exit;
    }

// Exécuter le script Python pour la découverte avec les données de l'image
// Construire la commande pour exécuter le script Python avec le fichier d'image
    $command = "python discover.py " . escapeshellarg($discoveryImageFile);
    $discoveryOutput = shell_exec($command);
// Vérifier si l'exécution du script Python a réussi ou non
    if ($discoveryOutput !== false) {
        echo 'Discovered Message: ' . $discoveryOutput;
    } else {
        echo 'Error executing the discovery Python script.';
    }
}
?>

    </section>
    
</body>
</html>