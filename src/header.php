<?php
session_start();
if(isset($_SESSION['customer_name'])){
    $name = $_SESSION['customer_name'];
}
?>
<header class="header">
    

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
            <a class="nav-link" href="profile.php">Profile</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="design.php">Saved Design</a>
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

      <?php
      
      $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);

      ?>

     

     

   </div>

</header>