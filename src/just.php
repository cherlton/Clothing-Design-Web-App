<?php
// Start session
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <h1>Welcome to the Design Clothes Website</h1>

    <?php
    // Check if there is any error message stored in the session
    if (isset($_SESSION['error_message'])) {
        echo '<p style="color: red;">' . $_SESSION['error_message'] . '</p>';
        // Clear the error message from the session
        unset($_SESSION['error_message']);
    }
    ?>

    <p>Please <a href="home.php">design your clothes</a>.</p>
</body>
</html>
