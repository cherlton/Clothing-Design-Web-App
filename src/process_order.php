<?php
session_start();
include 'connecting.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $total_product = mysqli_real_escape_string($conn, $_POST['total_product']);
    $total_price = mysqli_real_escape_string($conn, $_POST['total_price']);
    $street = mysqli_real_escape_string($conn, $_POST['street']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $zip = mysqli_real_escape_string($conn, $_POST['zip']);

    // Assuming $id is already set from the session
    if (isset($_SESSION['customer_id'])) {
        $id = $_SESSION['customer_id'];

        // Insert order details into the orders table
        $query = "INSERT INTO orders 
                  VALUES ('$method', '$total_product', '$total_price', '$id', '$street', '$state', '$zip')";

        if (mysqli_query($conn, $query)) {
            // Order successfully placed
            echo "Order placed successfully!";
        } else {
            // Error handling if insertion fails
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Customer ID not set!";
    }
}
?>