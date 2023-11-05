<?php
// Démarrer la session
session_start();

// Vérifier si la requête HTTP est de type POST (formulaire soumis)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $selectedUser = $_POST["userSelect"];
    $encryptionType = $_POST["encryptionType"];
    $messageContent = $_POST["messageContent"];
    $keyA = "";
    $keyB = "";

    // Vérifier si l'utilisateur est connecté et que la session contient un nom d'utilisateur authentifié
    if (isset($_SESSION['authenticatedUsername'])) {
        $loggedInUsername = $_SESSION['authenticatedUsername'];

        // Configuration de la connexion à la base de données (à remplacer par vos propres informations)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "boite_crypto";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérifier la connexion à la base de données
        if ($conn->connect_error) {
            die("Échec de la connexion à la base de données : " . $conn->connect_error);
        }

        // Gérer le cryptage du message en fonction du type de cryptage sélectionné
        switch ($encryptionType) {
            case "mirror":
                // Appeler le script Python pour le cryptage miroir
                $command = "python mirror.py " . escapeshellarg($messageContent);
                $reversed_message = shell_exec($command);
                break;
            case "affine":
                $keyA = $_POST["keyA"];
                $keyB = $_POST["keyB"];
                // Appeler le script Python pour le cryptage affine
                $command = "python affine.py " . escapeshellarg($keyA) . " " . escapeshellarg($keyB) . " " . escapeshellarg($messageContent);
                $reversed_message = shell_exec($command);
                if (trim($reversed_message) === "error") {
                    header("Location: home.php");
                    exit(); // Sortir pour éviter de sauvegarder un message vide
                }
                break;
            case "shift":
                // Récupérer la direction du décalage depuis le formulaire
                $shiftDirection = $_POST["shiftDirection"];
                // Vérifier la direction du décalage
                if ($shiftDirection === "left") {
                    $command = "python left.py " . escapeshellarg($messageContent);
                } elseif ($shiftDirection === "right") {
                    $command = "python right.py " . escapeshellarg($messageContent);
                }
                // Exécuter le script Python pour le décalage
                $reversed_message = shell_exec($command);
                if (trim($reversed_message) === "error") {
                    header("Location: home.php");
                    exit(); // Sortir pour éviter de sauvegarder un message vide
                }
                break;
        }

        // Vérifier si $reversed_message n'est pas vide
        if (!empty($reversed_message) && trim($reversed_message) !== "") {
            // Enregistrement du message dans la base de données
            $sql = "INSERT INTO messages (sender, receiver, message, A, B) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssss", $loggedInUsername, $selectedUser, $reversed_message, $keyA, $keyB);

            // Exécuter la requête SQL pour insérer le message dans la base de données
            if ($stmt->execute()) {
                echo "Message envoyé avec succès.";
                header("Location: home.php");
            } else {
                echo "Erreur lors de l'envoi du message : " . $stmt->error;
            }
        } else {
            header("Location: home.php");
            // Vous pouvez afficher un message d'erreur à l'utilisateur si nécessaire
        }

        // Fermer la requête préparée et la connexion à la base de données
        $stmt->close();
        $conn->close();
    } else {
        echo "User is not authenticated. Please log in.";
    }
} else {
    echo "Form not submitted.";
}
?>
