<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome to the Admin Dashboard</h1>
        <p>You are logged in as an admin.</p>
        
        <a href="admin_logout.php" class="btn btn-danger">Logout</a>

        <div class="list-group">
            <a href="./ii/Cartrecord.php" class="btn btn-primary">View Cart Report</a>
            <a href="./ii/recordpage.php" class="btn btn-primary">View Customer Report</a>
            <a href="./ii/CheckoutPagrecord.php" class="btn btn-primary">View Order Report</a>
            <a href="./ii/SelectedPagrecord.php" class="btn btn-primary">View Saved Design Report</a>
        </div>
    </div>
</body>
</html>
