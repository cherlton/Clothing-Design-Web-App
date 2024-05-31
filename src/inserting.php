<?php
session_start();
// Include the database connection file
include 'connecting.php';
//email

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../web/phpmailer/src/Exception.php';
require '../web/phpmailer/src/PHPMailer.php';
require '../web/phpmailer/src/SMTP.php';
// Collect form data
$name = $_POST['name'];
$id = $_POST['id_num'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone_number'];

// Check if the email already exists in the database
$sql_check_email = "SELECT * FROM customers WHERE email='$email'";
$result_check_email = $conn->query($sql_check_email);

// Check if the id_num already exists in the database
$sql_check_id = "SELECT * FROM customers WHERE cus_id_number='$id'";
$result_check_id = $conn->query($sql_check_id);

if ($result_check_email->num_rows > 0) {
    // Email already exists, set error message in session
    $_SESSION['error'] = "Email already exists";
    header("Location: ../web/modified form/signup.php");
    exit();
} else if ($result_check_id->num_rows > 0) {
    // ID number already exists, set error message in session
    $_SESSION['error'] = "ID number already exists";
    header("Location: ../web/modified form/signup.php");
    exit();
}

// Insert data into database
$sql = "INSERT INTO customers (cus_id_number, name, email, phone_number, password) VALUES ('$id', '$name', '$email', '$phone', '$password')";

if ($conn->query($sql) === TRUE) {

    //sent email
    $mail = new PHPMailer(true);
            
            try
            {
                //Server settings
                
                // Set mailer to use SMTP
                $mail->isSMTP(); 
                
                // Specify main and backup SMTP servers
                $mail->Host = 'smtp.gmail.com';
                
                // Enable SMTP authentication
                $mail->SMTPAuth = true;        
                
                // SMTP username
                $mail->Username = 'mahlanguzakhele063@gmail.com'; 
                
                // SMTP password
                $mail->Password = 'yyszmmomkdjtugpx';    
                
                // Enable TLS encryption, `ssl` also accepted
                $mail->SMTPSecure = 'ssl';    
                
                // TCP port to connect to
                $mail->Port = 465;                 

                //Recipients
                $mail->setFrom('mahlanguzakhele063@gmail.com', 'Group L Clothes Designer');
                
                // Add a recipient
                $mail->addAddress($email);  
                
                // Optional: Add reply-to address
                $mail->addReplyTo($email, 'Information');  

                // Content
                $mail->isHTML(true);  
                
                // Set email format to HTML
                $mail->Subject = 'Registration approved';
                $mail->Body    = "Hello <b>$name</b> you've been successfully registered<br>";
                                
                $mail->AltBody = '';

                $mail->send();
           

            } catch (Exception $e) {
                echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo} ');</script>";
            }

    //go to re
    header("Location: ../web/modified form/registration_successful.php");
} else {
    // Display error message if insertion fails
    $_SESSION['error'] = "Error occurred..Details Already exist: "; //. $conn->error;
    header("Location: ../web/modified form/signup.php");
}

$conn->close();
?>
