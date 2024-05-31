<?php
// Start session
session_start();
// Include database connection
include 'connecting.php';

// Get SESSION
if (isset($_SESSION['email_or_id'])) {
    $email_or_id = $_SESSION['email_or_id'];
}

// Fetch the name and ID based on the email/id
$query = "SELECT cus_id_number, name FROM customers WHERE (email = '$email_or_id' OR cus_id_number ='$email_or_id')";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$id_number = $row['cus_id_number'];
$name = $row['name'];

// Set ID and name in session
$_SESSION['customer_id'] = $id_number;
$_SESSION['customer_name'] = $name;




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Design a T-shirt</title>
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

        .tshirt-preview {
            width: 300px;
            height: 400px;
            background-image: url('https://res.cloudinary.com/dkkgmzpqd/image/upload/v1545217305/T-shirt%20Images/white.png');
            background-size: cover;
            background-position: center;
            margin: 0 auto 20px;
            position: relative;
        }

        .tshirt-preview .text-preview {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            color: #000;
            text-align: center;
        }

        .inputBox {
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
    <script>
        function updatePreview() {
            var text = document.getElementById("designText").value;
            var color = document.getElementById("textColor").value;
            var size = document.getElementById("textSize").value;
            var tshirtColor = document.getElementById("tshirtColor").value;
            var preview = document.getElementById("textPreview");

            preview.style.color = color;
            preview.style.fontSize = size + "px";
            preview.textContent = text;

            var tshirtPreview = document.querySelector('.tshirt-preview');
            switch (tshirtColor) {
                case 'white':
                    tshirtPreview.style.backgroundImage = "url('https://res.cloudinary.com/dkkgmzpqd/image/upload/v1545217305/T-shirt%20Images/white.png')";
                    break;
                case 'black':
                    tshirtPreview.style.backgroundImage = "url('https://res.cloudinary.com/dkkgmzpqd/image/upload/v1545217305/T-shirt%20Images/black.png')";
                    break;
                case 'blue':
                    tshirtPreview.style.backgroundImage = "url('https://res.cloudinary.com/dkkgmzpqd/image/upload/v1545217305/T-shirt%20Images/blue.png')";
                    break;
                case 'red':
                    tshirtPreview.style.backgroundImage = "url('https://res.cloudinary.com/dkkgmzpqd/image/upload/v1545217305/T-shirt%20Images/red.png')";
                    break;
                default:
                    tshirtPreview.style.backgroundImage = "url('https://res.cloudinary.com/dkkgmzpqd/image/upload/v1545217305/T-shirt%20Images/white.png')";
                    break;
            }
        }
    </script>
</head>

<body>

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
<div style="margin: 20px;">

    <div class="container">
        <h1 class="heading">Design Your T-shirt</h1>
        <div class="tshirt-preview">
            <div class="text-preview" id="textPreview">Your Text Here</div>
        </div>
        <form action="save_design.php" method="post">
            <div class="inputBox">
                <span>Text</span>
                <input type="text" id="designText" name="designText" placeholder="Enter your text"
                    oninput="updatePreview()" required>
            </div>
            <div class="inputBox">
                <span>Name</span>
                <input type="text" id="name" name="name" placeholder="Enter T shirt name"
                    oninput="updatePreview()" required>
            </div>
            <div class="inputBox">
                <span>Text Color</span>
                <input type="color" id="textColor" name="textColor" value="#000000" oninput="updatePreview()">
            </div>
            <div class="inputBox">
                <span>Text Size</span>
                <input type="number" id="textSize" name="textSize" value="24" min="10" max="72"
                    oninput="updatePreview()">
            </div>
            <div class="inputBox">
                <span>T-shirt Color</span>
                <select id="tshirtColor" name="tshirtColor" onchange="updatePreview()">
                    <option value="white">White</option>
                    <option value="black">Black</option>
                    <option value="blue">Blue</option>
                    <option value="red">Red</option>
                </select>
            </div>
            <input type="submit" value="Save Design" class="btn">
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>