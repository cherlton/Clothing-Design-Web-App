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
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="css/style.css">
   <style>
      body {
         font-family: Arial, sans-serif;
         background-color: #f7f7f7;
         margin: 0;
         padding: 0;
      }

      .container {
         max-width: 800px;
         margin: 50px auto;
         padding: 20px;
         text-align: center;
      }

      .heading {
         text-align: center;
         margin-bottom: 30px;
         color: #333;
      }

      .checkout-form {
         background-color: #fff;
         padding: 30px;
         border-radius: 8px;
         box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .display-order {
         margin-bottom: 20px;
      }

      .display-order span {
         display: block;
         margin-bottom: 10px;
         font-size: 16px;
         color: #333;
      }

      .grand-total {
         font-weight: bold;
      }

      .flex {
         display: flex;
         justify-content: space-between;
         flex-wrap: wrap;
      }

      .inputBox {
         width: 48%;
         margin-bottom: 20px;
      }

      .inputBox span {
         display: block;
         margin-bottom: 5px;
         font-size: 14px;
         color: #666;
      }

      .inputBox input,
      .inputBox select {
         width: 100%;
         padding: 10px;
         border: 1px solid #ccc;
         border-radius: 4px;
         font-size: 16px;
      }

      .btn {
         display: block;
         width: 100%;
         padding: 10px;
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
   <nav class="navbar navbar-dark bg-dark">
      <div class="container-fluid">
         <a class="navbar-brand" href="#">The L Group &trade;</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
            aria-controls="offcanvasDarkNavbar">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar">
            <div class="offcanvas-header">
               <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel"><?php echo $name; ?></h5>
               <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                  aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
               <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                  <li class="nav-item">
                     <a class="nav-link" href="profile.php">Profile</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="home.php">Home</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="design.php">Saved Design</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="cart.php">Cart</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="logout.php">Logout</a>
                  </li>
                  <li class="nav-item">
            <a class="nav-link" href="admin_login.php">View Report</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./ii/orderedItems.php">View Report</a>
          </li>
               </ul>
            </div>
         </div>
      </div>
   </nav>

   <div class="container">
      <section class="checkout-form">
         <h1 class="heading">Complete Your Order</h1>
        
            <div class="display-order">
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
               <span class="grand-total">Grand Total: R<?= $grand_total; ?>/-</span>
            </div>
            <h2>Place Your Order</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="method">Payment Method:</label><br>
        <input type="text" id="method" name="method" required><br>
        
        <label for="total_product">Total Product:</label><br>
        <input type="text" id="total_product" name="total_product" value=<?=$total_product?> disabled><br>
        
        <label for="total_price">Total Price:</label><br>
        <input type="text" id="total_price" name="total_price" value=R<?= $grand_total; ?> disabled><br>
        
        <label for="street">Street:</label><br>
        <input type="text" id="street" name="street" required><br>
        
        <label for="state">State:</label><br>
        <input type="text" id="state" name="state" required><br>
        
        <label for="zip">Zip:</label><br>
        <input type="text" id="zip" name="zip" required><br><br>
        <input type="submit" value="Place Order" class="btn" style="background-color: #007bff; color: #fff; border: none; border-radius: 4px; cursor: pointer; padding: 10px; width: 100%; transition: background-color 0.3s ease;">

       
    </form>

      </section>
   </div>



   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>