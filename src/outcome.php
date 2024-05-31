<!DOCTYPE HTML>
<html>
<body>
<table border=1 cellspacing =0>
<tr>
    <td>product id</td>
    <td>Image</td>
</tr>
<?php
include 'connecting.php'; // Assuming 'connecting.php' contains database connection code and initializes $conn

$i = 1;
$rows = mysqli_query($conn, "SELECT * FROM finalproduct");

while ($row = mysqli_fetch_assoc($rows)) : ?>
<tr>
    <td><?php echo $row["product_id"]; ?></td>
    <td><img src="../web/image/<?php echo $row["image_src"]; ?>" width="100" alt=""></td>
</tr>
<?php endwhile; ?>
</table>
</body>
</html>
