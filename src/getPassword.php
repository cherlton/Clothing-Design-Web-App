<?php
// Start session
session_start();
// Include database connection
include 'connecting.php';

// Get user's email and name from session
if (isset($_SESSION['email']) && isset($_SESSION['name'])) {
    $email = $_SESSION['email'];
    $name = $_SESSION['name'];
}

// Get ID number from form submission
$id = $_POST['id_num'];

// Fetch the password using prepared statement
$sql = "SELECT password FROM customers WHERE email = ? AND id_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $id);
$stmt->execute();
$result = $stmt->get_result();

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Fetch the password from the result
    $row = $result->fetch_assoc();
    $password = $row['password'];
} else {
    // No password retrieved
    $password = null;
}

// Destroy session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Retrieval</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        p {
            margin-bottom: 20px;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Password Retrieval</h1>
        <?php
        // Display fetched password if available
        if ($password !== null) {
            echo "<p>Hello <strong>$name</strong></p>";
            echo "<p>Here is your password: <strong>$password</strong></p>";
            echo '<p>Please click <a href="../web/modified form/login.php">here</a> to log in.</p>';
        } else {
            echo "<p>No password retrieved.</p>";
            echo "<p>No user found with the provided email or ID number.</p>";
            echo '<p>Please click <a href="../web/modified form/login.php">here</a> to start from re-entering details.</p>';
        }
        ?>
    </div>
</body>
</html>





