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


 // Replace 15 with the actual cart_id you want to retrieve
$sql = "SELECT sum(quantity) FROM cart WHERE cus_id_number = $id_number";
$result = $conn->query($sql);


?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lacquer&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Grandstander:ital,wght@0,100..900;1,100..900&family=Lacquer&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/0d8e1c9927.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Grandstander:ital,wght@0,100..900;1,100..900&family=Lacquer&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Freehand&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Freehand&family=MedievalSharp&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Freehand&family=MedievalSharp&family=VT323&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Freckle+Face&family=Freehand&family=MedievalSharp&family=VT323&display=swap"
        rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        
        .cart-icon {
            position: relative;
            display: inline-block;
        }
        .cart-quantity {
            position: absolute;
            top: -10px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px;
            font-size: 12px;
        }
    


         body {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    font-family: 'Poppins', Arial, sans-serif; /* Set font family */
    font-size: 16px; /* Set base font size */
    background-color: #eaf6fd; /* Set background color to light blue */
}

.container {
    width: 100vw;
    min-height: 100vh; /* Ensure container covers the viewport height */
    background-color: #ffffff; /* Set container background color */
}

/* Update font styles for headings */
h4,
h5,
h6 {
    margin-bottom: 10px; /* Add some spacing below headings */
    font-family: 'Grandstander', cursive; /* Use Grandstander font for headings */
    font-size: 24px; /* Set font size for headings */
    font-weight: bold; /* Ensure headings are bold */
    color: #333333; /* Set heading color */
}

/* Update font style for text */
p,
label,
button {
    font-family: 'Poppins', Arial, sans-serif; /* Use Poppins font for text */
    font-size: 18px; /* Set base font size for text */
    color: #555555; /* Set text color */
}

/* Update font style for navigation links */
.navbar-nav .nav-link {
    font-family: 'Poppins', Arial, sans-serif; /* Use Poppins font for navigation links */
    font-size: 18px; /* Set font size for navigation links */
    color: #ffffff; /* Set navigation link color */
}

/* Update background color and font style for offcanvas menu */
.offcanvas {
    background-color: #333333; /* Set offcanvas menu background color */
    font-family: 'Poppins', Arial, sans-serif; /* Use Poppins font for offcanvas menu */
}

/* Update font style and background color for submit button */
.submit-button button[type="submit"] {
    font-family: 'Poppins', Arial, sans-serif;
    font-size: 20px;
    padding: 10px 20px;
    border: none;
    background-color: #007bff; /* Set button background color */
    color: #ffffff; /* Set button text color */
    cursor: pointer;
    transition: background-color 0.3s ease;
    display: block;
    margin: auto;
}

.submit-button button[type="submit"]:hover {
    background-color: #0056b3; /* Darker background color on hover */
}

            .container {
                width: 100vw;
                height: auto;

                background-color: #fffdfd;
            }

            .image-holder {
                margin: auto;
                text-align: center;
                width: 70px;
                height: 70px;
                padding-bottom: 5px;
            }

            .image-holder img {
                border-radius: 5px;
                width: 100%;
                height: 100%;
            }

            .logos {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                width: 100vw;
            }

            .logo-item-fabric {
                position: relative;
                padding-top: 10px;
                width: 100px;
                height: 100px;
                /*border: 2px solid #cfcdcc;*/
                margin-right: 10px;
                border-radius: 8px;
            }

            .logo-item-clothing {
                position: relative;
                padding-top: 10px;
                width: 100px;
                height: 100px;
                /*border: 2px solid #cfcdcc;*/
                margin-right: 10px;
                border-radius: 8px;
                padding-right: 6;
            }

            .logo-item-graphic-tee {
                position: relative;
                padding-top: 10px;
                width: 100px;
                height: 100px;
                /*border: 2px solid #cfcdcc;*/
                margin-right: 10px;
                border-radius: 8px;
            }

            .logo-item-color {
                position: relative;
                padding-top: 10px;
                width: 100px;
                height: 100px;
                /*border: 2px solid #cfcdcc;*/
                margin-right: 10px;
                border-radius: 8px;
            }

            .logo-text {
                font-family: "Lacquer", system-ui;
                text-align: center;
            }

            i {
                text-align: center;
                position: relative;
                font-size: 25px;
                border-radius: 50%;
                width: 25px;
                height: 25px;
                background-color: #242424;
                color: white;

            }

            .selected {
                position: absolute;
                top: -4px;
                right: 8px;
                display: none;
            }

            .show {
                display: block;
            }

            h4,
            h5 {
                margin-bottom: 5;

                padding: 0;
                text-align: center;
                font-family: "Grandstander", cursive;
                font-size: 28px;
            }

            .clothing-item-section,
            .fabric-section,
            .graphic-design-section {


                margin-top: 5;
                margin-bottom: 5;
            }

            .color-picker label {
                font-family: "Poppins";

            }

            .size button {
                transform: translateY(-5px);
                text-align: center;
                font-family: "Poppins";
                font-size: 19;
                border: 1px solid #d1d1d1;
                height: 100%;

            }

            button i {
                transform: translate(6px,1px);
                font-size: 30;
                background-color: transparent;
                color: black;
            }

            button p {
                margin: 0;
            }

            .size {
                display: flex;
                margin-top: 5;
                margin-left: 10;
                justify-content: center;

            }

            #txtSize {
                font-family: 'Poppins';
                font-size: 20;

                margin-right: 15;
            }

            .size-section .menu {
                position: absolute;
                border-left: 1px solid rgb(205, 205, 205);
                border-right: 1px solid rgb(205, 205, 205);
                width: 83.5px;       
               
                background-color: #f5f5f5;
            }

            .menuItem {

                text-align: center;
                border-bottom: 1px solid rgb(214, 214, 214);
                font-family: "Poppins";
            }

            .dropmenu {
                position: relative;
            }

          

            .measurements {
                margin-top: 10;
                padding: 5;
                display: flex;justify-content: center;

            }

            .unit {
                font-family: "Poppins";
                width: 60;
                height: 50;
                border: 1px solid gainsboro;
                border-radius: 30%;
                margin-right: 25;
                margin-bottom: 10;
            }

          .clicked{
            color: rgb(66, 66, 66);
                background-color: #e6e6e6;
          }

            

            .unit p {
                text-align: center;
            }

            .size-section button {
                border-radius: 5px 5px 0px 0px;
            }

            .options {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            .optionsText {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .postionItem {
                border: 2px solid black;
                text-align: center;
                width: 120;

                margin: 9;
                font-family: "Poppins";
                border-radius: 9px;
            }

            .sizeRanger {
                margin-top: 20;
                margin-left: 20;
                margin-bottom: 20;
                text-align: center;
            }

            input[type="range"] {
                color: black;
                width: 300;
            }

            .displaySize {
                margin-left: 20;
            }

            .displaySize p {
                font-family: "Poppins";
                font-size: 25;
            }

            .buttons .menu {
                position: absolute;
                border-left: 1px solid rgb(205, 205, 205);
                border-right: 1px solid rgb(205, 205, 205);
                width: 79px;       
               z-index: 1;
                background-color: #f5f5f5;
            }
            .buttons .menu  p{
                font-family: "Poppins";
                font-size: 15px;
            }

            .buttons .menuItem {

                text-align: center;
                border-bottom: 1px solid rgb(214, 214, 214);
                font-family: "Poppins";
            
            }

            .buttons .dropmenu {
                position: relative;
                margin-right: 20;
                transform: translateY(2px);
            }
           

            .buttons .dropmenu button p {
                font-family: "Poppins";
                font-size: 20px;
            }

            button {
                display: flex;
                justify-content: center;
            }

            .buttons button {
                height: 100%;
                text-align: center;
                font-family: "Poppins";
                font-size: 19;

            }

            .buttons {
                display: flex;
            }

            .inputField input {
                width: 280;
                height: 40;
                font-family: "Poppins";
                font-size: 20;
            }

            .UserText {
                display: flex;
                width: 100%;
                justify-content: center;

            }

            .saveText button {
                font-family: "Poppins";
                font-size: 20px;
                text-align: center;
                padding: 10;
            }

            .logos .spinner {
                height: 50px;
                width: 50px;
                border: none;
                border-top: 5px solid #42a4f5;
                border-left: 5px solid #e6e6e6;
                border-right: 5px solid #e6e6e6;
                border-bottom: 5px solid #e6e6e6;
                border-radius: 50%;
                animation-name: Loading;
                animation-duration: 2s;
                animation-iteration-count: infinite;
                animation-timing-function: linear;

            }



            .unlock-form {
                top: 15;
                position: absolute;
                border: 1px solid black;
                z-index: 1;
                width: 60%;
                left: 20%;
                display: flex;
                justify-content: center;
                justify-self: center;
                border-radius: 5px;
                background-color: #f3f3f3;
                transform: translateX(-2000px);
                transition: opacity 1s linear;


            }

            .unlock-form2 {
                top: 15;
                position: absolute;
                border: 1px solid black;
                z-index: 1;
                width: 60%;
                left: 20%;
                display: flex;
                justify-content: center;
                justify-self: center;
                border-radius: 5px;
                background-color: #f3f3f3;
                transform: translateX(-2000px);
                transition: opacity 1s linear;

            }

            .unlock-form3 {
                top: 15;
                position: absolute;
                border: 1px solid black;
                z-index: 1;
                width: 60%;
                left: 20%;
                display: flex;
                justify-content: center;
                justify-self: center;
                border-radius: 5px;
                background-color: #f3f3f3;
                transform: translateX(-2000px);
                transition: opacity 1s linear;

            }

            .form-item-button {

                width: 100%;
                margin: auto;
                padding: 0;
                text-align: center;
                transform: translateY(-15px);

            }

            h6 {
                font-family: "Poppins";
                font-size: 15px;
            }

            .form-item-button button {
                transform: translate(58px);
                font-family: "Poppins";
                font-size: 15px;
                border-radius: 3px;
                background-color: transparent;
            }

            .close {
                top: 5;
                right: 10px;
                position: absolute;
            }

            .close i {
                background-color: transparent;
                color: #595959;
                font-size: 25;
            }

            .side-menu ul{
            position: relative;
            top: 50;
        }
        .side-menu li{
            padding: 10;
            list-style: none;
        }
        .side-menu a{
        text-decoration: none;
        color: white;
        font-family: 'Poppins';
        }
        .side-menu{
            position: absolute;
            background-color: rgb(33, 33, 33);
            width: 25vw;
            height: 100vh;
            
        }
        .iconbtn img{
            width: 30;
            height: 30;
        }
        .menu-toggler{
            position: absolute;
            top: 10;
            left: 10;

        }

        



        @keyframes Loading {
            to {
                transform: rotate(360deg);
            }

        }

        .logos {
            margin: auto;
        }

        .pre {
            text-align: center;
        }

      /* CSS for text design form */
.text-design-form {
    text-align: center;
    margin-top: 50px;
}

/* CSS for form elements */
.text-design-form form {
    display: inline-block;
    text-align: left;
}

.text-design-form form table {
    margin: auto;
}

.text-design-form form input[type="text"],
.text-design-form form select {
    font-family: 'Poppins', Arial, sans-serif;
    font-size: 20px;
    border: 1px solid #d1d1d1;
    padding: 5px 10px;
    margin-bottom: 10px;
    width: 300px; /* Adjusting width for consistency */
}

.text-design-form form label {
    font-family: 'Poppins', Arial, sans-serif; /* Match font for labels */
    font-size: 20px; /* Match font size for labels */
}

.text-design-form form input[type="range"] {
    width: 200px;
}

.text-design-form form select {
    background-color: #f5f5f5; /* Adding a light background */
}

/* Styling for text preview */
#text-preview {
    font-family: 'Poppins', Arial, sans-serif;
    font-size: 20px;
    margin-top: 10px;
}

/* Styling for submit button */
.text-design-form button[type="submit"] {
    font-family: 'Poppins', Arial, sans-serif;
    font-size: 20px;
    padding: 10px 20px;
    border: 1px solid #d1d1d1;
    background-color: #f5f5f5; /* Light background */
    cursor: pointer;
    transition: background-color 0.3s ease; /* Smooth transition effect */
    display: block; /* Center the button */
    margin: auto; /* Center the button */
}

.text-design-form button[type="submit"]:hover {
    background-color: #e0e0e0; /* Darker background on hover */
}
.submit-button {
    text-align: center;
}

    </style>
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
<?php
// Check if there are any rows in the result set
if ($result->num_rows > 0) {
    // Fetch the quantity from the first row
    $row = $result->fetch_assoc();
    $quantity = $row["sum(quantity)"];

    // Display the cart icon with the retrieved quantity
    echo "<div class='cart-icon'>
              <img src='bs.jpg' alt='Basket Icon' width='30px' height='30px'>
              <span class='cart-quantity'>" . $quantity . "</span>
          </div>";
} else {
    // If no rows are found, display the cart icon with a quantity of 0
    echo "<div class='cart-icon'>
              <img src='bs.jpg' alt='Basket Icon' width='30px' height='30px'>
              <span class='cart-quantity'>0</span>
          </div>";
}
?>
</div>

       <form action="selected.php" method="post">
        
        <div class="clothing-item-section">
            <h4>Select your Clothing Item </h4>
            <div class="logos">
                <div class="logo-item-clothing" data-index="0">
                    <div class="image-holder"><img src="./plain shirt.jpeg" alt=""></div>
                    <div class="logo-text"><input type="radio" id="shirt" name="clothes" value="shirt" value="t-shirt">
                       <label for="shirt">T shirt</label></div>
                    <div class="selected"><i class="fa fa-check"></i></div>
                </div>
                <div class="logo-item-clothing" data-index="1">
                    <div class="image-holder"><img src="./plain jacket.jpeg" alt=""></div>
                    <div class="logo-text">
                    <input type="radio" id="jacket" name="clothes" value="jacket">
                     <label for="jacket">Jacket</label>
                    </div>
                    <div class="selected"><i class="fa fa-check"></i></div>
                </div>
                <div class="logo-item-clothing" data-index="2">
                    <div class="image-holder"><img src="./plain hoodie.jpeg" alt=""></div>
                    <div class="logo-text">
                    <input type="radio" id="hoodie" name="clothes" value="hoodie">
                     <label for="hoodie">Hoodie</label>
                    </div>
                    <div class="selected"><i class="fa fa-check"></i></div>
                </div>

            </div>

        </div>

        <div class="fabric-section">
            <h4>Select your fabric</h4>
            <div class="logos">
                <div class="logo-item-fabric" data-index="0">
                    <div class="image-holder"><img src="./cotton.jpeg" alt=""></div>
                    <div class="logo-text">
                    <input type="radio" id="cotton" name="fabric" value="cotton">
                    <label for="shirt">Cotton</label> 
                    </div>
                    <div class="selected"><i class="fa fa-check"></i></div>
                </div>
                <div class="logo-item-fabric" data-index="1">
                    <div class="image-holder"><img src="./polyster.jpeg" alt=""></div>
                    <div class="logo-text">
                    <input type="radio" id="polyster" name="fabric" value="polyster">
                     <label for="hoodie">Polyster</label>
                    </div>
                    <div class="selected"><i class="fa fa-check"></i></div>
                </div>
                <div class="logo-item-fabric" data-index="2">
                    <div class="image-holder"><img src="./rayon.jpeg" alt=""></div>
                    <div class="logo-text">
                    <input type="radio" id="rayon" name="fabric" value="rayon">
                    <label for="jacket">Rayon</label>  
                    </div>
                    <div class="selected"><i class="fa fa-check"></i></div>
                </div>

            </div>

        </div>

        <div class="graphic-design-section">
            <h4>Color Designs</h4>
            <div class="logos">
                <div class="logo-item-color" data-index="0">
                    <div class="image-holder"><img src="black.jpg" alt=""></div>
                    <div class="logo-text">
                    <input type="radio" id="black" name="color" value="black">
                         <label for="black">Black</label>
                    </div>
                    <div class="selected"><i class="fa fa-check"></i></div>
                </div>
                <div class="logo-item-color" data-index="1">
                    <div class="image-holder"><img src="white.jpg" alt=""></div>
                    <div class="logo-text">
                    <input type="radio" id="white" name="color" value="white">
                      <label for="white">White</label>
                    </div>
                    <div class="selected"><i class="fa fa-check"></i></div>
                </div>
                <div class="logo-item-color" data-index="3">
                    <div class="image-holder"><img src="red.jpg" alt=""></div>
                    <div class="logo-text">
                    <input type="radio" id="red" name="color" value="red">
                    <label for="red">Red</label>
                    </div>
                    <div class="selected"><i class="fa fa-check"></i></div>
                </div>
            </div>
           
        </div>

        <div class="size-section">
            <h4>Select your Size</h4>
            <div class="size">
                <label for="size" style="font-family: 'Poppins'; font-size: 20px;">Size:</label>
                <select name="size" id="size" style="font-family: 'Poppins'; font-size: 20px; border: 1px solid #d1d1d1;">
                    <option value="small">Small</option>
                    <option value="medium">Medium</option>
                    <option value="large">Large</option>
                </select>
            </div>
        </div>

        <div class="graphic-design-section">
            <h4>Logo Selections</h4>
            <div class="logos">
                <div class="logo-item-color" data-index="0">
                    <div class="image-holder"><img src="java.jpg" alt=""></div>
                    <div class="logo-text"> <input type="radio" id="java" name="logo" value="java">
                      <label for="white">Java </label>
                    </div>
                    <div class="selected"><i class="fa fa-check"></i></div>
                </div>
                <div class="logo-item-color" data-index="1">
                    <div class="image-holder"><img src="starglow.jpg" alt=""></div>
                    <div class="logo-text"><input type="radio" id="starglow" name="logo" value="starglow">
                      <label for="white">Starglow</label>

                    </div>
                    <div class="selected"><i class="fa fa-check"></i></div>
                </div>
                <div class="logo-item-color" data-index="2">
                    <div class="image-holder"><img src="bleno.jpg" alt=""></div>
                    <div class="logo-text"><input type="radio" id="bleno" name="logo" value="bleno">
                      <label for="white">Bleno</label>

                    </div>
                    <div class="selected"><i class="fa fa-check"></i></div>
                </div>
                
            </div>

            <div class="submit-button" style="margin-top: 20px;">
    <button type="submit" name="add_to_cart" style="font-family: 'Poppins'; font-size: 20px; margin: auto;">
        Submit For Preview
    </button>
</div>

       
    </div>
    </form>
    <!--for text-->
    <div class="text-design-form">
    <h4>Design using text</h4>
    <form action="selected.php" method="post">
        <table>
            <tr>
                <td>Enter your text</td>
                <td><input type="text" id="text-input" name="text" required/></td>
            </tr>
            <tr>
                <td>Font size:</td>
                <td><input type="range" id="text-size-slider" min="10" max="50" value="20"></td>
            </tr>
            <tr>
                <td>Font family:</td>
                <td>
                    <select id="font-select">
                        <option value="Arial">Arial</option>
                        <option value="Times New Roman">Times New Roman</option>
                        <option value="Courier New">Courier New</option>
                        <option value="Verdana">Verdana</option>
                        <option value="Georgia">Georgia</option>
                    </select>
                </td>
            </tr>
        </table>
        <button type="submit" name="add_to_cart" style="font-family: 'Poppins'; font-size: 20px; ">Text Preview</button>
    </form>
    <div id="text-preview">Submit Text For Preview Text</div>
         <p>
            <a href="homePage.php">text T-shirt</a>
         </p>
</div>




</body>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const textInput = document.getElementById('text-input');
    const fontSizeSlider = document.getElementById('text-size-slider');
    const fontSelect = document.getElementById('font-select');
    const textPreview = document.getElementById('text-preview');

    // Event listener for text input
    textInput.addEventListener('input', updateTextPreview);

    // Event listener for font selection change
    fontSelect.addEventListener('change', updateTextPreview);

    // Event listener for font size slider change
    fontSizeSlider.addEventListener('input', updateTextFontSize);

    // Function to update text preview
    function updateTextPreview() {
        const font = fontSelect.value;
        const text = textInput.value;
        textPreview.style.fontFamily = font;
        textPreview.textContent = text;
    }

    // Function to update text font size
    function updateTextFontSize() {
        const fontSize = fontSizeSlider.value + 'px';
        textPreview.style.fontSize = fontSize;
    }
});


</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>