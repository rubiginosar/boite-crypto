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
    <title>Attaque de Mot de passe</title>
</head>
<body>
    <h1>Attaque de Mot de passe</h1>
    <form id="passwordForm" method="post">
        <label for="passwordType">Choisissez le type de mot de passe:</label>
        <select id="passwordType" name="passwordType" onchange="checkPassword()">
            <option value="3caracteres">Mot de passe de 3 caractères (0, 1)</option>
            <option value="5chiffres">Mot de passe de 5 chiffres (0..9)</option>
            <option value="5caracteres">Mot de passe de 5 caractères (a..z, A..Z, 0..9, +, *, ...)</option>
        </select>
        <br>

        <label for="password">Entrez le mot de passe:</label>
        <input type="text" id="password" name="password" oninput="checkPassword()">
        <br>

        <p id="error-message" style="color: red"><?php echo $errorMessage; ?></p>

        <button type="submit" name="attackButton">Attaquer</button>
    </form>

    <?php
        if (isset($_POST['attackButton'])) {
            if ($selectedPasswordType === '3caracteres') {
                $command = "python type1.py " . escapeshellarg($passwordInput);
                $reversed_message = shell_exec($command);
                // Exécutez l'attaque pour le mot de passe de 3 caractères ici
                echo 'Lancement de l\'attaque pour le mot de passe de 3 caracteres. Resultat : ' . $reversed_message;
            } elseif ($selectedPasswordType === '5chiffres') {
                $command = "python type2.py " . escapeshellarg($passwordInput);
                $reversed_message = shell_exec($command);
                // Exécutez l'attaque pour le mot de passe de 5 chiffres ici
                echo 'Lancement de l\'attaque pour le mot de passe de 5 chiffres.'. $reversed_message;
            } elseif ($selectedPasswordType === '5caracteres') {
                $command = "python type3.py " . escapeshellarg($passwordInput);
                $reversed_message = shell_exec($command);
                // Exécutez l'attaque pour le mot de passe de 5 caractères spéciaux ici
                echo 'Lancement de l\'attaque pour le mot de passe de 5 caracteres speciaux.'. $reversed_message ;
            }
        }
    ?>
</body>
</html>
