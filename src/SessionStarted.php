<?php
session_start();
// Get database connection
include 'connecting.php';

// Retrieve form data
$email_or_id = $_POST['email_or_id'];
$password = $_POST['password'];

// Query to check if user with given email and password exists
$sql = "SELECT * FROM customers WHERE (email=? OR cus_id_number=?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email_or_id, $email_or_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    if ($user['password'] == $password) {
        // User found and password matches, store email in session and redirect to restricted page
        $_SESSION['email_or_id'] = $email_or_id;
        header("Location: home.php");
    } else {
        // Password doesn't match, redirect back to login page with error message
        header("Location: ../web/modified form/login.php?error=2");
    }
} else {
    // User not found, redirect back to login page with error message
    header("Location: ../web/modified form/login.php?error=1");
}
?>

