<?php
session_start();

include 'connecting.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve payment details from the form
    $total_price = $_POST['total_price'];
    $card_number = mysqli_real_escape_string($conn, $_POST['card_number']);
    $expiry_date = mysqli_real_escape_string($conn, $_POST['expiry_date']);
    $cvv = mysqli_real_escape_string($conn, $_POST['cvv']);
    
    // Assuming $id is already set from the session
    if (isset($_SESSION['customer_id'])) {
        $id = $_SESSION['customer_id'];
        
        // Insert payment details into the payment table
        $insert_payment_query = "INSERT INTO payment (cus_id_number, total_price, card_number, expiry_date, cvv) 
                                 VALUES ('$id', '$total_price', '$card_number', '$expiry_date', '$cvv')";

        if (mysqli_query($conn, $insert_payment_query)) {
            // Payment details successfully inserted
            // Delete the cart items
            $delete_cart_query = "DELETE FROM cart WHERE cus_id_number=$id";
            if (mysqli_query($conn, $delete_cart_query)) {
                // Cart successfully deleted
                // Redirect to a success page or perform any other action
                header("Location: payment_success.php");
                exit();
            } else {
                // Error handling if deletion fails
                echo "Error deleting cart: " . mysqli_error($conn);
            }
        } else {
            // Error handling if insertion fails
            echo "Error: " . $insert_payment_query . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Customer ID not set!";
    }
} else {
    echo "Invalid request!";
}
?>
