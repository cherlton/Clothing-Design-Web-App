<?php
session_start();

include 'connecting.php';

if (isset($_SESSION['customer_name'])) {
   $name = $_SESSION['customer_name'];
}
if (isset($_SESSION['customer_id'])) {
   $id = $_SESSION['customer_id'];
}

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
       $select_cart_price_query = "SELECT SUM(price * quantity) AS price_total FROM cart WHERE cus_id_number = '$id'";
       $result = mysqli_query($conn, $select_cart_price_query);
       ///
       if ($result) {
          // Fetch the total price from the result
          $row = mysqli_fetch_assoc($result);
          $price_total = $row['price_total'];
    
          // If total price is null, set it to 0
          $price_total = $price_total ? $price_total : 0;
    
          // Store the total price in session
          $_SESSION['price_total'] = $price_total;
          //delete the cart 
          "DELETE TABLE cart WHERE";
       // Insert order details into the orders table
       $query = "INSERT INTO orders (methodpay, total_product, total_price, cus_id_number, street, state, zip) 
                 VALUES ('$method', '$total_product', '$price_total', '$id', '$street', '$state', '$zip')";

               

       }
       if (mysqli_query($conn, $query)) {
           // Order successfully placed, redirect to payment.php
           header("Location: payment.php");
           exit(); // Make sure to exit after redirection
       } else {
           // Error handling if insertion fails
           echo "Error: " . $query . "<br>" . mysqli_error($conn);
       }
   } else {
       echo "Customer ID not set!";
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Additional CSS for Payment Form */

.payment-form {
    background-color: #fff;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.inputBox {
    margin-bottom: 20px;
}

.inputBox span {
    display: block;
    margin-bottom: 5px;
    color: #333;
    font-weight: bold;
}

.inputBox input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.btn {
    display: inline-block;
    width: auto;
    padding: 10px 20px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
}

    </style>
</head>

<body>
    
    <div class="container">
        <section class="payment-form">
            <h1 class="heading">Payment</h1>
            <?php
               $select_cart = mysqli_query($conn, "SELECT * FROM cart  where cus_id_number = '$id' ");
               $total = 0;
               $grand_total = 0;
               if (mysqli_num_rows($select_cart) > 0) {
                  while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                     $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
                     $grand_total = $total += $total_price;
                     //set grand to session
                     $_SESSION['grand_total'] = $grand_total;
                     echo "<span>{$fetch_cart['name']} ({$fetch_cart['quantity']})</span>";
                  }
               } else {
                  echo "<div class='display-order'><span>Your cart is empty!</span></div>";
               }
               // Fetch total quantity of products in the cart
          $select_cart_quantity_query = "SELECT SUM(quantity) AS total_quantity FROM cart WHERE cus_id_number = '$id'";
          $result_quantity = mysqli_query($conn, $select_cart_quantity_query);
          $total_quantity_row = mysqli_fetch_assoc($result_quantity);
          $total_product = $total_quantity_row['total_quantity'];
               ?>
               <br>
              <b> <span class="grand-total">Grand Total: R<?= $grand_total; ?>/-</span></b>
            <form action="process_payment.php" method="post">
                <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
                <div class="inputBox">
                    <span>Card Number</span>
                    <input type="text" name="card_number" maxlength="10" required>
                </div>
                <div class="inputBox">
                    <span>Expiry Date (MMYY)</span>
                    <input type="text" name="expiry_date" maxlength="4" required>
                </div>
                <div class="inputBox">
                    <span>CVV</span>
                    <input type="text" name="cvv" maxlength="3" required>
                </div>
                <input type="submit" value="Pay Now" class="btn">
            </form>
        </section>
    </div>
</body>

</html>
