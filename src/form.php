<?php
// Read the JSON data sent via POST
$jsonData = file_get_contents('php://input');

// Decode the JSON data
$data = json_decode($jsonData, true);

// Assuming your JSON data looks like:
// {
//     "color": "red",
//     "clothingType": "tshirt",
//     "logo": "small",
//     "logoPosition": "top"
// }

// Access the values
$color = $data['color'];
$clothingType = $data['clothingType'];
$logo = $data['logo'];
$logoPosition = $data['logoPosition'];

// Now you can do whatever you want with these values, for example, save them to a database
// Or process them in any other way

// Sending a response back (optional)
$response = [
    'color' => $color,
    'clothingType' => $clothingType
];

header('Content-Type: application/json');
echo json_encode($response);
?>
