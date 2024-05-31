<!DOCTYPE html>
<html>
<head>
    <title>Preview Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .container {
            text-align: center;
            margin-top: 20px;
        }
        h1, h2 {
            font-family: 'Poppins', sans-serif;
        }
        p {
            font-size: 20px;
        }
        .btn-custom {
            font-size: 20px;
            font-family: 'Poppins', sans-serif;
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
        }
        .btn-custom:hover {
            background-color: #45a049;
        }
        img {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!--session name -->
    <?php
    session_start();
    if (isset($_SESSION['customer_name'])) {
        $name = $_SESSION['customer_name'];
    }
    ?>
    <nav class="navbar navbar-dark bg-dark">
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
                            <a class="nav-link" href="profile.php">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./ii/orderedItems.php">Order</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                        <li class="nav-item">
            <a class="nav-link" href="admin_login.php">View Report</a>
          </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- preview code -->
    <div class="container">
        <?php
        // Default selections
        $_SESSION['selected_cloth'] = 'shirt';
        $_SESSION['selected_fabric'] = 'cotton';
        $_SESSION['selected_color'] = 'white';
        $_SESSION['selected_size'] = 'small';
        $_SESSION['selected_logo'] = '';

        // Calculate total price
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

        $total_price = $base_prices[$_SESSION['selected_cloth']] ?? 0;

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // If form submitted via description, extract keywords and update selections
            if (isset($_POST['text'])) {
                // Retrieve text description from form
                $text = $_POST['text'];

                // Extract keywords from the text description
                $keywords = explode(" ", $text);

                // Initialize variables to store extracted keywords
                $selected_cloth = "";
                $selected_fabric = "";
                $selected_color = "";
                $selected_size = "";
                $selected_logo = "";

                // Loop through the extracted keywords to identify clothing attributes
                foreach ($keywords as $keyword) {
                    // Check for keywords related to clothing attributes
                    if (in_array(strtolower($keyword), ['shirt', 't-shirt', 'hoodie', 'jacket'])) {
                        $selected_cloth = strtolower($keyword);
                    } elseif (in_array(strtolower($keyword), ['black', 'red', 'white'])) {
                        $selected_color = strtolower($keyword);
                    } elseif (in_array(strtolower($keyword), ['cotton', 'polyester', 'rayon'])) {
                        $selected_fabric = strtolower($keyword);
                    } elseif (in_array(strtolower($keyword), ['small', 'medium', 'large'])) {
                        $selected_size = strtolower($keyword);
                    } elseif (in_array(strtolower($keyword), ['java', 'starglow', 'bleno'])) {
                        $selected_logo = strtolower($keyword);
                    }
                }

                // Update session variables with selected values
                $_SESSION['selected_cloth'] = $selected_cloth;
                $_SESSION['selected_fabric'] = $selected_fabric;
                $_SESSION['selected_color'] = $selected_color;
                $_SESSION['selected_size'] = $selected_size;
                $_SESSION['selected_logo'] = $selected_logo;
            } else {
                // If form submitted via button, update selections based on button values
                $selected_cloth = isset($_POST['clothes']) ? $_POST['clothes'] : 'shirt';
                $selected_fabric = isset($_POST['fabric']) ? $_POST['fabric'] : 'cotton';
                $selected_color = isset($_POST['color']) ? $_POST['color'] : 'white';
                $selected_size = isset($_POST['size']) ? $_POST['size'] : 'small';
                $selected_logo = isset($_POST['logo']) ? $_POST['logo'] : '';

                // Update session variables with selected values
                $_SESSION['selected_cloth'] = $selected_cloth;
                $_SESSION['selected_fabric'] = $selected_fabric;
                $_SESSION['selected_color'] = $selected_color;
                $_SESSION['selected_size'] = $selected_size;
                $_SESSION['selected_logo'] = $selected_logo;
            }

            // Calculate total price based on selections
            $total_price = $base_prices[$_SESSION['selected_cloth']] ?? 0;
            if ($_SESSION['selected_logo']) {
                $total_price += $logo_prices[$_SESSION['selected_logo']] ?? 0;
            }
        }

        // Display the selected design and total price
        echo "<h2>Selected Design</h2>";
        echo "<p>Clothes: " . $_SESSION['selected_cloth'] . "</p>";
        echo "<p>Fabric: " . $_SESSION['selected_fabric'] . "</p>";
        echo "<p>Color: " . $_SESSION['selected_color'] . "</p>";
        echo "<p>Size: " . $_SESSION['selected_size'] . "</p>";
        echo "<p>Logo: " . ($_SESSION['selected_logo'] ?: 'None') . "</p>";
        echo "<p>Total Price: R$total_price</p>";

        // Display the corresponding image based on the selected options
        $selected_cloth_lower = strtolower($_SESSION['selected_cloth']);
        $selected_color_lower = strtolower($_SESSION['selected_color']);

        if ($_SESSION['selected_logo']) {
            // Construct file path for logo image based on selected logo and color
            $selected_logo_lower = strtolower($_SESSION['selected_logo']);
            $selected_logo_filename = "../web/image/{$selected_cloth_lower}/{$selected_logo_lower}{$selected_color_lower}.jpg";

            if (file_exists($selected_logo_filename)) {
                // Display logo image
                echo '<img src="' . $selected_logo_filename . '" alt="Selected Logo" width="200" height="200">';
            } else {
                echo '<p>No image available for the selected logo.</p>';
            }
        } else {
            // Construct file path for T-shirt image
            $tshirt_image_filename = "../web/image/{$selected_cloth_lower}/plain{$selected_color_lower}.jpg";

            if (file_exists($tshirt_image_filename)) {
                // Display T-shirt image only if no logo is selected
                echo '<img src="' . $tshirt_image_filename . '" alt="Selected Design" width="200" height="200">';
            } else {
                echo '<p>The system did not get your design well. Please re-design.</p>';
            }
        }
        ?>
        <p>    
        <form action="home.php" method="post">
            <button type="submit"  class="btn-custom">RE-DESIGN</button>
        </form>
        <form action="saveDesign.php" method="post">
     <table>
       <tr>
        <td tyle="text-align: center;">Give product a name</td>
        <td style="text-align: center;"> <input type="text" name="name" required /></td>
       </tr>
       
        </table>
            <button type="submit" name="design"  class="btn-custom">Save design</button>
        </form>
        </p>
       
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
