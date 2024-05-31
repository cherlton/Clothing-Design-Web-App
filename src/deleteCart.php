

<?php
session_start();
include 'connecting.php';

// Get session
if (isset($_SESSION['customer_id'])) {
    $id = $_SESSION['customer_id'];
}

 //Delete product from cart
if (isset($_POST['delete_product'])) {
    $delete_product_id = $_POST['delete_product_id'];
    // Delete from cart logic...
}

// Redirect back to design.php with success message
if (isset($message)) {
    header("Location: design.php?success=Item successfully deleted from cart");
    exit();
}

?>