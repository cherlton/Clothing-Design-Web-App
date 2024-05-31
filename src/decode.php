<?php

// Connect to your database
$servername = "localhost";
$username = "app";
$password = "123";
$dbname = "branddb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// *Get available colors from the 'images' table* (assuming color is stored in a 'color_name' column)

// Build the query to get the image details based on selected color
$sql = "SELECT Image FROM finalproduct WHERE produc_id = 1";

// If color is not selected, get a random image (optional)
// if ($selected_color == "") {
//   $sql = "SELECT * FROM ex ORDER BY RAND() LIMIT 1";
// }

$result = $conn->query($sql);

// Close connection
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Image Selection by Color</title>
</head>
<body>
  <h1>Select Your Image Color</h1>
  

  <?php
  // Display the selected image details (if any)
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $image_data = $row["Image"]; // Base64 encoded image data
    

    // Check for valid Base64 data (optional)
    if (base64_decode($image_data, true) === false) {
      echo "<br>Error: Invalid image data.";
    } else {
      // *Improved MIME type handling* (choose one approach):

      // Option 1: Store MIME type separately (assuming 'mime_type' column exists)
      if (isset($row['mime_type'])) {
        $mime_type = $row['mime_type'];
      } else {
        // Default fallback (modify as needed)
        $mime_type = 'jpeg';
      }

      // Option 2: Server-side analysis (replace with your logic)
      // $mime_type = analyze_image_data($image_data); // Replace with your function
      echo "<img src='data:image/" . $mime_type . ";base64," . $image_data . "' alt='$color Image'>";  
    }
  } else {
    echo "<br>No image selected yet.";
  }
  ?>

</body>
</html>
