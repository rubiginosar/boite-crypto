<!DOCTYPE html>
<html>
<head>
    <title>CryptoBox | Mailbox</title>
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
      form {
        display:flex;
        justify-content:space-around;
        }
      .submit {
          font-size:20px;
          padding: 10px 10px; /* Adjust padding as needed */
          background-color: #2980b9;
          color: #fff;
          border: none;
          border-radius: 5px;
          cursor: pointer;
          margin-top:50px;
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
          <li><a href="./att.php">Passwords</a></li>
          <li><a href="./stegano.php">Steganographie</a></li>
          <li><a href="./logout.php">Logout</a></li>
        </ul>
      </nav>
    </header>
</body>
</html>
<?php

// Paramètres de connexion à la base de données
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'boite_crypto';

// Ouvre une connexion à la base de données
$mysqli = new mysqli($hostname, $username, $password, $database);

// Vérifie s'il y a une erreur de connexion
if ($mysqli->connect_error) {
    die("Échec de la connexion à la base de données : " . $mysqli->connect_error);
}

// Définit un temps d'exécution maximum pour votre script (en secondes)
$maxExecutionTime = 55;  // Définit une valeur légèrement inférieure à max_execution_time de PHP

// Obtient l'heure de début
$startTime = time();

echo '<div id="output">'; // Débute le conteneur de sortie

// Définit une variable pour indiquer le type d'attaque (dictionnaire ou force brute)
$attackType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifie si l'un des boutons a été cliqué
    if (isset($_POST["dictionaryAttack"])) {
        $attackType = "dictionary";
    } elseif (isset($_POST["bruteForceAttack"])) {
        $attackType = "bruteforce";
    }
}

// Vérifie le type d'attaque et exécute la logique appropriée
if ($attackType === "dictionary" ) {
    // Ouvre le fichier "mdp.txt" en lecture
    $file = fopen("mdp.txt", "r");

    if ($file) {
        $matchCount = 0;
        $matchFound = false; // Indicateur pour indiquer si une correspondance a été trouvée

        // Parcourt chaque ligne du fichier de mots de passe
        while (($md5Password = fgets($file)) !== false) {
            // Supprime les caractères de nouvelle ligne s'ils sont présents
            $md5Password = trim($md5Password);

            // Vérifie le temps d'exécution restant
            $remainingTime = $maxExecutionTime - (time() - $startTime);

            // S'il ne reste pas suffisamment de temps, quitte le script
            if ($remainingTime < 5) {  // Définit une marge de sécurité pour la sortie (par exemple, 5 secondes)
                break;
            }

            // Démarre le chronomètre pour cette correspondance
            $matchStartTime = microtime(true);

            // Utilise une instruction préparée pour gérer en toute sécurité la valeur du mot de passe
            $sql = "SELECT username, password FROM users WHERE password = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("s", $md5Password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Correspondance de mot de passe trouvée
                $matchCount++;
                $matchFound = true; // Définit le drapeau sur vrai
                $row = $result->fetch_assoc();
                $username = $row["username"];
                $matchEndTime = microtime(true);
                $matchTime = $matchEndTime - $matchStartTime;
                echo "Match Found ($matchCount): Username: $username, Password: $md5Password, Time Taken: $matchTime seconds<br>";
                // Vide le tampon de sortie pour l'affichage immédiat
                ob_flush();
                flush();
            }
        }

        // Ferme le fichier
        fclose($file);

        // Si aucune correspondance n'a été trouvée, affiche "Aucune correspondance trouvée"
        if (!$matchFound) {
            echo "No match found, try attacking by brute force \n";
        }
    } else {
        echo "Failed to open the file.";
    }
}
else { if ($attackType === "bruteforce")
  header("Location: att.php");
}
echo '</div>'; // Termine le conteneur de sortie

// Ferme la connexion à la base de données
$mysqli->close();

// Si aucun nom d'utilisateur n'a été défini
if (!isset($username)) {
    echo "None found.\n";
}
?>

?>

<form method="post">
    <button type="submit" name="dictionaryAttack" class="submit">Attack by Dictionary</button>
    <button type="submit" name="bruteForceAttack" class="submit">Attack by Brute Force</button>
</form>
