<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_discover"])) {
    // Handle the image discovery process here
    $discoveryImageFile = $_FILES["discovery_image"]["tmp_name"];

    // Ensure that the temporary directory used by PHP has write permissions
    $tmpDir = 'C:/xampp/tmp/';

    if (!is_writable($tmpDir)) {
        echo 'Error: The temporary directory does not have write permissions.';
        exit;
    }

    // Execute the Python script for discovery with the image data
    $command = "python discover.py " . escapeshellarg($discoveryImageFile);
    $discoveryOutput = shell_exec($command);

    if ($discoveryOutput !== false) {
        echo 'Discovered Message: ' . $discoveryOutput;
    } else {
        echo 'Error executing the discovery Python script.';
    }
}
?>
