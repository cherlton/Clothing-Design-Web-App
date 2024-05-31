<?php
session_start();

include 'connecting.php';

// Check if the user is logged in
if (isset($_SESSION['customer_id'])) {
    $id=$_SESSION['customer_id'];
   
}



// Retrieve the saved designs
$query = "SELECT * FROM `design` WHERE cus_id_number = '$id'";
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
    <title>My Designs</title>
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

        .tshirt-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .tshirt-preview {
            width: 300px;
            height: 400px;
            background-size: cover;
            background-position: center;
            position: relative;
            margin-bottom: 20px;
        }

        .tshirt-preview .text-preview {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
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



        
    </style>
</head>
<nav class="navbar navbar-dark bg-dark ">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">The L Group &trade; </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel"><?php echo $name; ?></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link" href="profile.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php">Cart</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="design.php">Saved Design</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="admin_login.php">View Report</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./ii/orderedItems.php">Order</a>
          </li>
        </ul>
        
      </div>
    </div>
  </div>
</nav>

<body>
    <div class="container">
        <h1 class="heading">My Designs</h1>
        <div class="tshirt-container">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $tshirtImage = getTshirtImage($row['cloth_color']);
                    echo '<div class="tshirt-preview" style="background-image: url(\'' . $tshirtImage . '\');">
                            <div class="text-preview" style="color: ' . htmlspecialchars($row['text_color']) . '; font-size: ' . htmlspecialchars($row['text_size']) . 'px;">' . htmlspecialchars($row['text']) . '</div>
                          </div>
                          <form action="add_to_cart.php" method="post">
                            <input type="hidden" name="design_id" value="' . $row['design_id'] . '">
                            <input type="submit" value="Add to Cart" class="btn">
                          </form>';
                }
            } else {
                echo '<p>You have no designs saved.</p>';
            }
            ?>
        </div>
        <button id="removeDesignBtn" class="btn btn-danger mt-3">Remove from Design</button>
        <a href="home.php" class="btn btn-primary mt-3">Create New Design</a>
    </div>
    <script>
        document.getElementById('removeDesignBtn').addEventListener('click', function() {
            // Perform the action to remove items from the design using JavaScript
            // For example, you can clear the tshirt-container or hide the tshirt previews
            document.querySelector('.tshirt-container').innerHTML = '';
        });
    </script>
</body>

</html>