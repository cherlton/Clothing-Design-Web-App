<?php
session_start();

include 'connecting.php';

// Check if the user is logged in
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['customer_id'])) {
        echo "Customer ID not set!";
        exit();
    }

    $customer_id = $_SESSION['customer_id'];
    $design_id = mysqli_real_escape_string($conn, $_POST['design_id']);

    // Check if the design is already in the cart
    $check_query = "SELECT * FROM `cart` WHERE cus_id_number = '$customer_id' AND design_id = '$design_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Design is already in the cart, update quantity
        $update_query = "UPDATE `cart` SET quantity = quantity + 1 WHERE cus_id_number = '$customer_id' AND design_id = '$design_id'";
        mysqli_query($conn, $update_query);
    } else {
        // Insert new design into cart
        $insert_query = "INSERT INTO `cart` (cus_id_number, design_id) VALUES ('$customer_id', '$design_id')";
        mysqli_query($conn, $insert_query);
    }

    // Perform deletions after inserting/updating the cart
  
  
    header('Location: view_cart.php');
    exit();
}
?>
