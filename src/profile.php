<!-- get name -->
<?php
// Start session
session_start();
// Include database connection
include 'connecting.php';

// Get SESSION
if (isset($_SESSION['email_or_id'])) {
    $email_or_id = $_SESSION['email_or_id'];
}

// Fetch the name based on the email
$query = "SELECT name FROM customers WHERE (email = '$email_or_id' OR cus_id_number ='$email_or_id')";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$name = $row['name'];
?>

<!-- Php update email -->
<?php
//  database connection
include 'connecting.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_email'])) {
    // Sanitize and retrieve the new email from the form
    $newEmail =  $_POST['email'];

    // Check if the new email is already in use
    $checkQuery = "SELECT * FROM customers WHERE email = '$newEmail'";
    $checkResult = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        echo "Email already exists!";
    } else {
        // Update the user's email in the database
        if (isset($_SESSION['email_or_id'])) {
            $oldIdentifier = $_SESSION['email_or_id']; // Get the logged-in user's email or ID
            $updateQuery = "UPDATE customers SET email = '$newEmail' WHERE email = '$oldIdentifier' OR cus_id_number = '$oldIdentifier'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                // Email updated successfully
                echo "Email updated successfully!";
                $_SESSION['email_or_id'] = $newEmail; // Update the session with the new email
            } else {
                echo "Error updating email: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!--Update name -->
<?php
//  database connection
include 'connecting.php';
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_name'])) {
    // Sanitize and retrieve the new name from the form
    $newName = $_POST['name'];

    // Update the user's name in the database
    if (isset($_SESSION['email_or_id'])) {
        $email_or_id = $_SESSION['email_or_id']; // Get the logged-in user's email

        // Update the user's name in the database
        $updateQuery = "UPDATE customers SET name = '$newName' WHERE email = '$email_or_id' OR cus_id_number ='$email_or_id'";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            // Name updated successfully
            echo "Name updated successfully!";
        } else {
            echo "Error updating name: " . mysqli_error($conn);
        }
    }
}
?>
<!-- update password -->
<?php
include 'connecting.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_pass'])) {
    // Sanitize and retrieve the new password from the form
    $newPass = $_POST['password'];
    $confirmPass = $_POST['confirm_password'];

    // Check if the passwords match
    if ($newPass !== $confirmPass) {
        echo "Passwords do not match!";
    } else {
        // Check if the password meets complexity requirements
        $hasSpecialChar = preg_match('/[^a-zA-Z0-9]/', $newPass); // At least one special character
        $hasNumericDigit = preg_match('/\d/', $newPass); // At least one numeric digit
        $hasLowerCase = preg_match('/[a-z]/', $newPass); // At least one lowercase letter
        $hasUpperCase = preg_match('/[A-Z]/', $newPass); // At least one uppercase letter

        if (!$hasSpecialChar || !$hasNumericDigit || !$hasLowerCase || !$hasUpperCase) {
            echo "Password must contain at least one special character, one numeric digit, one lowercase letter, and one uppercase letter!";
        } else {
            // Update the user's password in the database
            if (isset($_SESSION['email_or_id'])) {
                $email_or_id = $_SESSION['email_or_id']; // Get the logged-in user's email

                // Update the user's password in the database
                $updateQuery = "UPDATE customers SET password = '$newPass' WHERE email = '$email_or_id' OR cus_id_number = '$email_or_id'";
                $updateResult = mysqli_query($conn, $updateQuery);

                if ($updateResult) {
                    // Password updated successfully
                    echo "Password updated successfully!";
                } else {
                    echo "Error updating password: " . mysqli_error($conn);
                }
            }
        }
    }
}
?>
<!--acount delete-->
<?php
// Include the database connection file
include 'connecting.php';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['del_acc'])) {
    // Check if the user is logged in
    if (isset($_SESSION['customer_id'])) {
        $cus_id_number = $_SESSION['customer_id'];

        // Begin a transaction
        mysqli_begin_transaction($conn);

        try {
            // Prepare and execute the delete statements in the correct order

            // Delete from orders
            $deleteQuery = "DELETE FROM orders WHERE cus_id_number = ?";
            $stmt = mysqli_prepare($conn, $deleteQuery);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $cus_id_number);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Error deleting from orders: " . mysqli_stmt_error($stmt));
                }
                mysqli_stmt_close($stmt);
            } else {
                throw new Exception("Error preparing statement for orders: " . mysqli_error($conn));
            }

            // Delete from cart
            $deleteQuery = "DELETE FROM cart WHERE cus_id_number = ?";
            $stmt = mysqli_prepare($conn, $deleteQuery);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $cus_id_number);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Error deleting from cart: " . mysqli_stmt_error($stmt));
                }
                mysqli_stmt_close($stmt);
            } else {
                throw new Exception("Error preparing statement for cart: " . mysqli_error($conn));
            }

            // Delete from products
            $deleteQuery = "DELETE FROM products WHERE cus_id_number = ?";
            $stmt = mysqli_prepare($conn, $deleteQuery);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $cus_id_number);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Error deleting from products: " . mysqli_stmt_error($stmt));
                }
                mysqli_stmt_close($stmt);
            } else {
                throw new Exception("Error preparing statement for products: " . mysqli_error($conn));
            }

            // Delete from design
            $deleteQuery = "DELETE FROM design WHERE cus_id_number = ?";
            $stmt = mysqli_prepare($conn, $deleteQuery);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $cus_id_number);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Error deleting from design: " . mysqli_stmt_error($stmt));
                }
                mysqli_stmt_close($stmt);
            } else {
                throw new Exception("Error preparing statement for design: " . mysqli_error($conn));
            }

            // Delete from customers last
            $deleteQuery = "DELETE FROM customers WHERE cus_id_number = ?";
            $stmt = mysqli_prepare($conn, $deleteQuery);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "s", $cus_id_number);
                if (!mysqli_stmt_execute($stmt)) {
                    throw new Exception("Error deleting from customers: " . mysqli_stmt_error($stmt));
                }
                mysqli_stmt_close($stmt);
            } else {
                throw new Exception("Error preparing statement for customers: " . mysqli_error($conn));
            }

            // Commit the transaction
            mysqli_commit($conn);

            // Clear session data
            session_unset();
            session_destroy();

            // Redirect to account deleted page
            header("Location: accountDeleted.php");
            exit();
        } catch (Exception $e) {
            // Rollback the transaction on error
            mysqli_rollback($conn);
            echo "<p>Error deleting account: " . $e->getMessage() . "</p>";
        }
    }
}
?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet"> 
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
    <Style>
        i{
            width: 100;
            height: 100;
        }
        body{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-position: center;
            background-size: cover;

        }
        .containerUser{
            position: relative;
            width: 100vw;
            height: 100vh;
            

        }
        .headerUser{
            display: flex;
            flex-direction: row;
            justify-content: space-around;
           
           padding: 20;
           width: 50%;
           margin: auto;
           font-family: 'Poppins';


        }
        .cardUser{     
            position: relative;
            display: flex;
            flex-direction: row;
            padding: 20;
            justify-content: center;
            box-shadow: 1px 2px 8px  rgb(115, 112, 112);
            margin-bottom: 40;
            border-radius: 10px;
            font-family: 'Poppins';
            width: 50%;
            margin-left: auto;
            margin-right: auto;

        }

        .profile-pic{
            width: 50;
            height: 50;
        }
        .bodyUser{
            padding: 50;
        }
        .icon img{
            width: 15;
            height: 15
        }
        .icon{
            position: relative;
            left: 10;
            top: 2;
        }
        .icon2 img{
            width: 30;
        }
        .icon2{
            position: relative;
            left: -6;
            top: 13;
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
            background-color: rgb(44, 43, 43);
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
        .menu-toggler button {
            border-radius: 5px;
            border:none;
        }
        .form-control1{
            position: absolute;
            margin: auto;
            padding: 20;
            text-align: center;
            background-color: rgb(222, 222, 222);
            z-index: 1;
            border-radius: 15px;
            width: 50%;
        }
        .form-control2{
            position: absolute;
            margin: auto;
            padding: 20;
            text-align: center;
            background-color: rgb(222, 222, 222);
            z-index: 1;
            border-radius: 15px;
            width: 50%;
        }
        .form-control3{
            position: absolute;
            margin: auto;
            padding: 20;
            text-align: center;
            background-color: rgb(222, 222, 222);
            z-index: 1;
            border-radius: 15px;
            width: 50%;
        }
        .form-item{
            margin: 10;
        }
        .form-item input{
            padding: 5;
            font-family:monospace;
            border-top: none;
            border-left: none;
            border-right: none;
            background-color: transparent;
            border-bottom: 1px solid rgb(86, 86, 86);
        }
        .form-item input:focus{
            outline: none;
        }
        .submit-btn{
            margin: 5;
            display: flex;
            justify-content: space-around;
        }
        .submit-btn button{
            text-align: center;
            width: 150;
            height: 40;
            border-radius: 5px;
            border: none;
            font-family: 'Poppins';
          

        }
        .hide{
            display: none;
        }
        .option-txt button{
          border: none;
          font-family: 'Poppins';
          background-color: transparent;
          font-size: 16px;
          cursor: pointer;
        }
        .show{}

    </Style>
    <style>
    .profile-pic {
        cursor: pointer;
        transition: transform 0.3s ease; /* Add transition effect */
    }
    .profile-pic img {
        width: 100px; /* Initial size */
        height: 100px; /* Initial size */
        border-radius: 50%; /* To make it round */
        transition: width 0.3s ease, height 0.3s ease; /* Add transition effect */
    }
    .profile-pic.clicked img {
        width: 50px; /* Reduced size */
        height: 50px; /* Reduced size */
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
            <a class="nav-link" href="home.php">Home</a>
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
            <a class="nav-link" href="./ii/orderedItems.php">Order</a>
          </li>
        </ul>
        
      </div>
    </div>
  </div>
</nav>

    <div class="containerUser">
        
        
        
        <div class="headerUser">
            <div class="profile-pic" onclick="uploadProfilePicture()"><img src="./Images/icons8-profile-picture-48.png" alt="pic"></div>
            <div class="name-text"><p><?php echo $name; ?></p></div>
        </div>
        <div class="bodyUser">

            <div class="cardUser">
               <div class="option-txt"><button onclick="showForm1()" id="update">Update Name</button> </div>
               <div class="icon"><img src="./Images/icons8-pen-52.png" alt=""></div>

                <div class="form-control1 hide" >
                    <h3>Update Name</h3>
                    <!-- Update name -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="form1">
                        <div class="form-item"> <label>Enter New Name  </label><input type="text" name="name"></div>
                        <div class="submit-btn"><button type="submit" name="update_name">Change Name</button><button onclick="close()" id="close" >Close</button></div>
                       
                    </form>
                </div>
            </div>
            
          
            <div class="cardUser">
                <div class="option-txt"><button onclick="showForm2()" id="updateEm">Update Email</button> </div>
                <div class="icon"><img src="./Images/icons8-pen-52.png" alt=""></div>
             
                <div class="form-control2 hide">
                    <h3>Update Email</h3>
                    <!-- Update email -->
                    <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
                        <div class="form-item"> <label>Enter New Email  </label><input type="email" name="email" /></div>
                        <div class="submit-btn"><button type="submit" name="update_email">Change Email</button><button onclick="close()" id="close" >Close</button></div>
                       
                    </form>
                </div>

            
            </div>
            
          
             <div class="cardUser">
                <div class="option-txt"> <button onclick="showForm3()"  id="password">Update Password</button>  </div>
                <div class="icon"><img src="./Images/icons8-pen-52.png" alt=""></div>
             
                <div class="form-control3 hide">
                    <h3>Update Passsword</h3>
                    <!-- update password -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
                    
                        <div class="form-item"> <label>Enter New Password  </label><input type="password" name="password" id="password"></div>
                        <div class="form-item"> <label>Confirm  Password  </label><input type="password" name="confirm_password" id="confirm_password"></div>
                        <div id="password_match_message" style="display: none; color: red;">Passwords do not match!</div>
                        <table>
                       <tr>
                <td><input type="checkbox" id="show_password_checkbox" onclick="PasswordVisibility()"> </td>
                <td> <label for="show_password_checkbox">Show Password</label> </td>
                  </tr>
                 </table>
                        <div class="submit-btn"><button type="submit" name="update_pass">Change Password</button><button onclick="close()" id="close" >Close</button></div>
                       
                    </form>
                </div>
            
            
            </div>

        </div>

       

    <div class="cardUser">
      <!-- Delete Account -->
         
         <div class="option-txt"><button onclick="showForm4()" id="deletePass">Delete Account</button> </div>
         <div class="icon2"><img src="./Images/icons8-delete-60.png" alt=""></div>
         <div class="form-control4 hide" >
                    <h3>Delete Account</h3>
                    <!-- account delete -->
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" id="form4">
                        <div class="form-item"> <label>Are you sure you want to delete your account?</label></div>
                        <div class="submit-btn"><button type="submit" name="del_acc" >Yes</button><button onclick="close()" id="close" >No</button></div>
                       
                    </form>
               
    
</div>
    </div>

    <script>
          let clickMenu =  false;
          
          const form1_div = document.querySelector('.form-control1')
          const form2_div = document.querySelector('.form-control2')
          const form3_div = document.querySelector('.form-control3')
          const form4_div = document.querySelector('.form-control4')
          const menu = document.querySelector('.side-menu')
        function showForm1(){
           
    form1_div.classList.remove('hide')
    form1_div.classList.add('show')
    
    disable();
   
        }

        function showForm2(){
            
    form2_div.classList.remove('hide')
    form2_div.classList.add('show')
    disable();
    }

    function showForm3(){
            
    form3_div.classList.remove('hide')
    form3_div.classList.add('show')
    disable();
    }
    function showForm4(){
            
            form4_div.classList.remove('hide')
            form4_div.classList.add('show')
            disable();
            }
    function showSideMenu(){
    
     clickMenu = !clickMenu
     if(clickMenu){
        
        menu.classList.remove('hide')
        const iconDiv = document.querySelector('.iconbtn')
        iconDiv.querySelector('img').src='./Images/icons8-close-50.png'
     }else {
  
        menu.classList.add('hide')
        const iconDiv = document.querySelector('.iconbtn')
        iconDiv.querySelector('img').src='./Images/icons8-menu-50.png'
     }
        
     
       
     
    }

    function disable(){
        const updateBtn = document.getElementById("update");
        const changeBtn = document.getElementById("password");
        const updateEm = document.getElementById("updateEm");
        if(form1_div.classList.contains("show")){
            changeBtn.disabled = true;
            updateEm.disabled = true;
        
        }else if(form2_div.classList.contains("show")){
            updateBtn.disabled = true;
            updateEm.disabled = true;
        }else if(form3_div.classList.contains("show")){
            updateBtn.disabled = true;
            updateEm.disabled = true;
        }else if(form4_div.classList.contains("show")){
            updateBtn.disabled = true;
            updateEm.disabled = true;
            changeBtn.disabled = true;
        }
    }
    
    function close(){
        const closeBtn = document.getElementById("close");
    
        form1_div.classList.add('hide')
        form1_div.classList.remove('show')

        form2_div.classList.add('hide')
        form2_div.classList.remove('show')

        form3_div.classList.add('hide')
        form3_div.classList.remove('show')

        form4_div.classList.add('hide')
        form4_div.classList.remove('show')
        
    }

   //About password
   
    // Function to hide the error message after 2 seconds
    setTimeout(function() {
        var errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.style.display = 'none';
        }
    }, 2000);
    
    //password visibility
    function PasswordVisibility() {
        var passwordInputs = document.querySelectorAll('input[type="password"]');
        var showPasswordCheckbox = document.getElementById('show_password_checkbox');
        
        passwordInputs.forEach(function(input) {
            input.type = showPasswordCheckbox.checked ? 'text' : 'password';
        });
    }
    
    //form validating
    
    function checkForm() {
        if (!checkPasswordMatch()) {
            return false;
        }

        
        return true;
    } 
    
    
    //Password validation
    function checkPasswordMatch() {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirm_password').value;
        var password_match_message = document.getElementById('password_match_message');

        // Check if passwords match
        if (password !== confirmPassword) {
            password_match_message.innerText = 'Passwords do not match!';
            password_match_message.style.display = 'block';
            setTimeout(function() {
                password_match_message.style.display = 'none';
            }, 2000);
            return false;
        }

        // Check if password meets complexity requirements
        var hasSpecialChar = /[^a-zA-Z0-9]/.test(password); // At least one special character
        var hasNumericDigit = /\d/.test(password); // At least one numeric digit
        var hasLowerCase = /[a-z]/.test(password); // At least one lowercase letter
        var hasUpperCase = /[A-Z]/.test(password); // At least one uppercase letter

        if (!hasSpecialChar || !hasNumericDigit || !hasLowerCase || !hasUpperCase) {
            password_match_message.innerText = 'Password must contain at least one special character, one numeric digit, one lowercase letter, and one uppercase letter!';
            password_match_message.style.display = 'block';
            setTimeout(function() {
                password_match_message.style.display = 'none';
            }, 5000); // Longer display time for complex password requirement
            return false;
        }

        return true;
    }
    //
    function toggleSize() {
    var profilePic = document.querySelector('.profile-pic');
    var profileImg = document.querySelector('.profile-pic img');

    // Toggle the clicked class to change size and trigger uploadProfilePicture()
    profilePic.classList.toggle('clicked');

    // If the image is now small (clicked), trigger uploadProfilePicture()
    if (profilePic.classList.contains('clicked')) {
        uploadProfilePicture();
    }
}

function uploadProfilePicture() {
    // Create an input element of type file
    var input = document.createElement('input');
    input.type = 'file';

    // Listen for changes in the input element
    input.addEventListener('change', function() {
        var file = input.files[0];
        
        // Check if a file is selected
        if (file) {
            var reader = new FileReader();

            // Read the uploaded file as Data URL
            reader.readAsDataURL(file);

            // When the file is loaded, update the profile picture
            reader.onload = function() {
                var imgDataUrl = reader.result;
                document.querySelector('.profile-pic img').src = imgDataUrl;

                // Send the image to the server for storage
                var formData = new FormData();
                formData.append('profile_pic', file);
                fetch('save_profile_picture.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to save profile picture');
                    }
                    console.log('Profile picture saved successfully');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            };
        }
    });

    // Trigger click event on the input element
    input.click();
}
    </script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>