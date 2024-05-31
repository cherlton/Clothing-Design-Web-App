<?php
// Start session
session_start();

// Include database connection file
include "connecting.php";
$quantity = 2;
$total_amount = 10;
$product_id = 16;

// Construct the insert query with placeholders for security
$insert_selection_query = "INSERT INTO ordertb (quantity, total_amount, product_id) VALUES (?, ?, '')";

// Prepare the statement to prevent SQL injection
$stmt = mysqli_prepare($conn, $insert_selection_query);

// Bind the values to the prepared statement
mysqli_stmt_bind_param($stmt, "idi", $quantity, $total_amount, $product_id);

// Execute the prepared statement
mysqli_stmt_execute($stmt);

// Check if insert was successful (optional)
if (mysqli_stmt_affected_rows($stmt) > 0) {
  echo "Order inserted successfully!";
} else {
  echo "Error inserting order: " . mysqli_stmt_error($stmt);
}

// Close the prepared statement
mysqli_stmt_close($stmt);

?>
