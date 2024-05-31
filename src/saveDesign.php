<?php
// Start session
session_start();

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["design"])) {
    // Include database connection file
    include "connecting.php";

    // Get form data
    $name = $_POST['name'];

    // Function to calculate the price based on selected options
    function calculatePrice($cloth_type, $logo) {
        $base_prices = [
            'shirt' => 70,
            'hoodie' => 150,
            'jacket' => 200
        ];

        $logo_prices = [
            'java' => 90,
            'starglow' => 50,
            'bleno' => 75
        ];

        $price = $base_prices[$cloth_type] ?? 0;
        if ($logo) {
            $price += $logo_prices[$logo] ?? 0;
        }
        return $price;
    }

    // Check if there's a selected design in the session
    if (isset($_SESSION['selected_cloth'], $_SESSION['selected_color'], $_SESSION['selected_fabric'], $_SESSION['customer_id'])) {
        $selected_cloth = $_SESSION['selected_cloth'];
        $selected_color = $_SESSION['selected_color'];
        $selected_fabric = $_SESSION['selected_fabric'];
        $selected_logo = $_SESSION['selected_logo'] ?? '';
        $selected_size = $_SESSION['selected_size'] ?? '';
        $user_id_number = $_SESSION['customer_id'];

        // Determine image source based on selection
        $image_src = "../web/image/$selected_cloth/plain$selected_color.jpg";
        if (!empty($selected_logo)) {
            $image_src = "../web/image/$selected_cloth/" . $selected_logo . $selected_color . ".jpg";
        }

        // Calculate price
        $price = calculatePrice($selected_cloth, $selected_logo);

        // Insert selections into 'design' table
        $insert_selection_query = "INSERT INTO design (cloth_type, cloth_fabric, cloth_color, logo, cloth_size, cus_id_number,text_color,text,text_size) 
                                   VALUES ('$selected_cloth', '$selected_fabric', '$selected_color', '$selected_logo', '$selected_size', '$user_id_number','null','null','null')";
        if (mysqli_query($conn, $insert_selection_query)) {
            // Get the last inserted selection ID
            $selection_id = mysqli_insert_id($conn);

            // Insert the selected image and price into 'products' table
            $insert_image_query = "INSERT INTO products (name, image, design_id, price, cus_id_number) 
                                   VALUES ('$name', '$image_src', '$selection_id', '$price', '$user_id_number')";
            if (mysqli_query($conn, $insert_image_query)) {
                // Redirect to home page after successful insertion
                header("Location: home.php");
                exit();
            } else {
                echo "Error inserting into products table: " . mysqli_error($conn);
            }
        } else {
            echo "Error inserting into design table: " . mysqli_error($conn);
        }
    } else {
        echo "Required session variables are not set!";
    }
} else {
    echo "Invalid request!";
}
?>
