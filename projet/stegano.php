<!DOCTYPE html>
<html>
<head>
    <title>Hide and Discover Message</title>
</head>
<body>
    <h1>Hide Message</h1>
    <form action="stegano.php" method="post" enctype="multipart/form-data">
        Select an image: <input type="file" name="image" accept="image/*"><br>
        Enter your message: <input type="text" name="message"><br>
        <input type="submit" name="submit_hide" value="Hide Message">
    </form>

    <h1>Discover Message</h1>
    <form action="discover.php" method="post" enctype="multipart/form-data">
        Select an image: <input type="file" name="discovery_image" accept="image/*"><br>
        <input type="submit" name="submit_discover" value="Discover Message">
    </form>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["submit_hide"])) {
        $message = $_POST["message"];
        $imageFile = $_FILES["image"]["tmp_name"];

        // Execute the Python script with message and image data
        $command = "python hide.py " . escapeshellarg($message) . " " . escapeshellarg($imageFile);
        $output = shell_exec($command);

        if ($output !== false) {
            echo 'Message hidden successfully. Download Image';
        } else {
            echo 'Error executing the Python script.';
        }
    } elseif (isset($_POST["submit_discover"])) {
        // Handle the image discovery process here
        $discoveryImageFile = $_FILES["discovery_image"]["tmp_name"];

        // Execute the Python script for discovery
        $command = "python discover.py " . escapeshellarg($discoveryImageFile);
        $discoveryOutput = shell_exec($command);

        if ($discoveryOutput !== false) {
            echo 'Discovered Message: ' . $discoveryOutput;
        } else {
            echo 'Error executing the discovery Python script.';
        }
    }
}
?>
