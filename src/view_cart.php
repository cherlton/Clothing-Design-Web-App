<?php
session_start();

include 'connecting.php';

// Check if the user is logged in


$customer_id = $_SESSION['customer_id'];

if (isset($_POST['update_quantity_btn'])) {
    $update_quantity = $_POST['update_quantity'];
    $cart_id = $_POST['cart_id'];
    $update_quantity_query = mysqli_query($conn, "UPDATE `cart_tb` SET quantity = '$update_quantity' WHERE cart_id = '$cart_id' AND customer_id = '$customer_id'");
    if ($update_quantity_query) {
        header('location:view_cart.php');
    }
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM `cart_tb` WHERE cart_id = '$remove_id' AND customer_id = '$customer_id'");
    header('location:view_cart.php');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart_tb` WHERE customer_id = '$customer_id'");
    header('location:view_cart.php');
}

// Retrieve the cart items
$query = "SELECT * from cart WHERE cus_id_number=$customer_id`";
          
$result = mysqli_query($conn, $query);

function getTshirtImage($color)
{
    switch ($color) {
        case 'black':
            return 'https://res.cloudinary.com/dkkgmzpqd/image/upload/v1545217305/T-shirt%20Images/black.png';
        case 'blue':
            return 'https://res.cloudinary.com/dkkgmzpqd/image/upload/v1545217305/T-shirt%20Images/blue.png';
        case 'red':
            return 'https://res.cloudinary.com/dkkgmzpqd/image/upload/v1545217305/T-shirt%20Images/red.png';
        case 'white':
        default:
            return 'https://res.cloudinary.com/dkkgmzpqd/image/upload/v1545217305/T-shirt%20Images/white.png';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
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
        }

        .heading {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .cart-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .cart-item {
            width: 300px;
            height: 400px;
            background-size: cover;
            background-position: center;
            position: relative;
            margin-bottom: 20px;
        }

        .cart-item .text-preview {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
        }

        .cart-item .actions {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
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

        .btn.remove {
            background-color: #dc3545;
        }

        .btn.remove:hover {
            background-color: #c82333;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="heading">My Cart</h1>
        <div class="cart-container">
            <table border 1 cellplacing=0>

                <thead>
                    <th>image</th>
                    <th>name</th>
                    <th>price</th>
                    <th>quantity</th>
                    <th>total price</th>
                    <th>action</th>
                </thead>

                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $tshirtImage = getTshirtImage($row['cloth_color']);
                            echo '<div class="cart-item" style="background-image: url(\'' . $tshirtImage . '\');">
                            <div class="text-preview" style="color: ' . htmlspecialchars($row['text_color']) . '; font-size: ' . htmlspecialchars($row['text_size']) . 'px;">' . htmlspecialchars($row['text']) . '</div>
                            <div class="quantity">Quantity: ' . htmlspecialchars($row['quantity']) . '</div>
                            <div class="actions">
                                <form action="" method="post">
                                    <input type="hidden" name="cart_id" value="' . $row['cart_id'] . '">
                                    <input type="number" name="update_quantity" min="1" value="' . htmlspecialchars($row['quantity']) . '" class="quantity-input">
                                    <input type="submit" value="Update" name="update_quantity_btn" class="btn btn-primary">
                                </form>
                                <a href="view_cart.php?remove=' . $row['cart_id'] . '" class="btn remove" onclick="return confirm(\'Remove item from cart?\')">Remove</a>
                            </div>
                          </div>';
                        }
                    } else {
                        echo '<p>Your cart is empty.</p>';
                    }
                    ?>
        </div>
        <a href="home.php" class="btn btn-primary mt-3">Continue Designing</a>
        <?php if (mysqli_num_rows($result) > 0) { ?>
            <a href="cart.php?delete_all" class="btn btn-danger mt-3"
                onclick="return confirm('Are you sure you want to delete all items from your cart?')">Delete All</a>
        <?php } ?>
    </div>
</body>

</html>