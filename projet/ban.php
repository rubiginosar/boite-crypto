<?php

// Function to check if the user is banned and manage login attempts
function check_if_banned($login_attempt = false, $login_success = false)
{
    $limit = 3; // Maximum login attempts allowed before banning

    // Database connection setup
    $string = "mysql:host=localhost;dbname=boite_crypto";
    if (!$con = new PDO($string, 'root', '')) {
        die("Could not connect");
    }

    $ip = get_ip(); // Get the user's IP address

    // Query the database to check if the IP is banned
    $query = "SELECT * FROM banned_table WHERE ip_address = :ip LIMIT 1";
    $stm = $con->prepare($query);

    if ($stm) {
        $check = $stm->execute([
            'ip' => $ip,
        ]);

        if ($check) {
            $row = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (is_array($row) && count($row) > 0) {
                $row = $row[0];
                $time = time();

                if ($row['banned'] > $time) {
                    // If the user is banned, redirect to a denied page
                    header("Location: denied.php");
                    die;
                } else {
                    if ($login_attempt) {
                        if ($row['login_count'] >= $limit) {
                            // Ban the user if they've exceeded the login attempts
                            $query = "UPDATE banned_table SET banned = :banned, login_count = 0  
                                WHERE id = :id LIMIT 1";

                            $expire = ($time + (60 * 1)); // Ban for 1 minute
                            $stm = $con->prepare($query);
                            $check = $stm->execute([
                                'id' => $row['id'],
                                'banned' => $expire,
                            ]);
                            return;
                        } elseif ($login_success) {
                            // Reset the login count on successful login
                            $query = "UPDATE banned_table SET login_count = 0 
                                WHERE id = :id LIMIT 1";

                            $stm = $con->prepare($query);
                            $check = $stm->execute([
                                'id' => $row['id'],
                            ]);
                        } else {
                            // Increment the login count on login failure
                            $query = "UPDATE banned_table SET login_count = login_count + 1 
                                WHERE id = :id LIMIT 1";

                            $stm = $con->prepare($query);
                            $check = $stm->execute([
                                'id' => $row['id'],
                            ]);
                        }
                    }
                }
                return;
            }
        }
    }

    // If no record exists for the IP, initialize login count and banned status
    $login_count = 0;
    $banned = 0;

    $query = "INSERT INTO banned_table (ip_address, login_count, banned) 
    VALUES (:ip_address, :login_count, :banned)";

    $stm = $con->prepare($query);
    $check = $stm->execute([
        'ip_address' => $ip,
        'banned' => $banned,
        'login_count' => $login_count,
    ]);
}

// Function to get the user's IP address
function get_ip()
{
    $ip = "";

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Use the forwarded IP if available
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    if (isset($_SERVER['REMOTE_ADDR'])) {
        // Use the remote IP if forwarded IP is not available
        return $_SERVER['REMOTE_ADDR'];
    }

    return $ip;
}

?>
