<?php
// Start a session
session_start();
// Include the database connection file
include 'connecting.php';
// Collect form data
$email = $_POST['email'];
// Check if email exists in the database
$sql = "SELECT email, name FROM customers WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    // Email found in the database
    $row = $result->fetch_assoc();
    $_SESSION['email'] = $row['email']; // Set email in session
    $_SESSION['name'] = $row['name']; // Set name in session
} else {
    // Email not found in the database
    $_SESSION['email'] = $email; // Set email in session
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Id number</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        input[type="email"] {
            width: 300px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
    <div id="id_validation_message" style="display: none; color: red;"></div>
        <h1>We got your email confirm with your ID Number to get Password</h1>
        <form action="getPassword.php" method="post" onsubmit="return checkForm()">
            <input type="text" name="id_num"id="id_num" placeholder="ID number" maxlength="13"required>
            <input type="submit" value="Get Password">
        </form>
    </div>
</body>
<script>
      //form validating
      function checkForm() {

        if (!checkIdInput()) {
            return false;
        }
       
        return true;
    }
     //id validation
     function checkIdInput() {
        var idInput = document.getElementById('id_num').value;
        var id_validation_message = document.getElementById("id_validation_message");

        // Check if input is 13 digits long
        if (idInput.length !== 13) {
            id_validation_message.innerText = "ID number must be 13 digits long";
            id_validation_message.style.display = 'block';
            setTimeout(function() {
                id_validation_message.style.display = 'none';
            }, 2000); // Hide the message after 2 seconds
            return false;
        }

        // Check if input consists of numbers only
        if (!/^\d+$/.test(idInput)) {
            id_validation_message.innerText = "ID number must contain only numeric digits";
            id_validation_message.style.display = 'block';
            setTimeout(function() {
                id_validation_message.style.display = 'none';
            }, 2000); // Hide the message after 2 seconds
            return false;
        }

        // Extract the first 6 digits representing the date of birth
        var dobPart = idInput.substring(0, 6);
        var year = dobPart.substring(0, 2);
        var month = dobPart.substring(2, 4);
        var day = dobPart.substring(4, 6);

        // Check if the first 6 digits form a valid date of birth
        var dateOfBirth = new Date("20" + year, month - 1, day); // Assuming 20th century for the year
        if (dateOfBirth.getFullYear() !== parseInt("20" + year) ||
            dateOfBirth.getMonth() !== (month - 1) ||
            dateOfBirth.getDate() !== parseInt(day)) {
            id_validation_message.innerText = "Invalid date of birth in ID number";
            id_validation_message.style.display = 'block';
            setTimeout(function() {
                id_validation_message.style.display = 'none';
            }, 2000); // Hide the message after 2 seconds
            return false;
        }

        id_validation_message.innerText = ""; // Clear any previous error message
        id_validation_message.style.display = 'none'; // Hide the error message
        return true;
    }
    
</script>
</html>
