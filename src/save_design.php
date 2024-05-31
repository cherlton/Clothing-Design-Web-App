<?php
session_start();
include 'connecting.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_SESSION['customer_id'];
    $text = mysqli_real_escape_string($conn, $_POST['designText']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $textColor = mysqli_real_escape_string($conn, $_POST['textColor']);
    $textSize = mysqli_real_escape_string($conn, $_POST['textSize']);
    $tshirtColor = mysqli_real_escape_string($conn, $_POST['tshirtColor']);

    // Insert into design table
    $insert_design_query = "INSERT INTO design (design_id,cloth_type, cloth_fabric, cloth_color, logo, cloth_size, cus_id_number, text_color, text,text_size) VALUES ('null', 't-shirt','null', '$tshirtColor', 'null', 'null', '$customer_id', '$textColor', '$text','$textSize')";
    if (mysqli_query($conn, $insert_design_query)) {
        // Get the last inserted design ID
        $design_id = mysqli_insert_id($conn);

        // Insert into products table
        $insert_product_query = "INSERT INTO products (product_id,name, image, design_id, price, cus_id_number) VALUES ('null','$name', 'plain shirt', $design_id, '70', '$customer_id')";
        if (mysqli_query($conn, $insert_product_query)) {
            header('Location: view_designs.php');
            exit();
        } else {
            echo "Error: " . $insert_product_query . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Error: " . $insert_design_query . "<br>" . mysqli_error($conn);
    }
}
?>
