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
