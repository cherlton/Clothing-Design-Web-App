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
        $query = "INSERT INTO orders (methodpay, total_product, total_price, cus_id_number, street, state, zip) 
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
            margin-top: 30px;
            color: #333;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            color: #555;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Place Your Order</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="method">Payment Method:</label><br>
        <input type="text" id="method" name="method" required><br>
        
        <label for="total_product">Total Product:</label><br>
        <input type="text" id="total_product" name="total_product" required><br>
        
        <label for="total_price">Total Price:</label><br>
        <input type="text" id="total_price" name="total_price" required><br>
        
        <label for="street">Street:</label><br>
        <input type="text" id="street" name="street" required><br>
        
        <label for="state">State:</label><br>
        <input type="text" id="state" name="state" required><br>
        
        <label for="zip">Zip:</label><br>
        <input type="text" id="zip" name="zip" required><br><br>
        
        <input type="submit" value="Place Order">
    </form>
</body>
</html>
