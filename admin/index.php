<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

  <!-- Check Admin Rights -->
  <?php include "includes/admin_check.php"; ?>

  <!-- Header -->
  <?php include "includes/admin_header.php"; ?>

  <body>

    <!-- Navbar -->
    <?php include "includes/admin_navbar.php"; ?>


    <div id="wrapper">
      <!-- Sidebar -->
      <?php include "includes/admin_sidebar.php"; ?>

      <div id="content-wrapper">
        <div class="container-fluid">
          <h1 class="text-center">Welcome to Admin Page (<small><?php echo $_SESSION['username'] . " - " . $_SESSION['role']; ?></small>)</h1>

          <hr>

          <div class="row">
            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="far fa-clipboard"></i>
                  </div>
                  <?php
                    $query = "SELECT * FROM posts";
                    $items = mysqli_query($conn, $query);
                    $item_count = mysqli_num_rows($items);
                    
                    echo "<div class='mr-5'>{$item_count} Posts!</div>";
                  ?>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="posts.php">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="far fa-clipboard"></i>
                  </div>
                  <?php
                    $query = "SELECT * FROM comments";
                    $items = mysqli_query($conn, $query);
                    $item_count = mysqli_num_rows($items);
                    
                    echo "<div class='mr-5'>{$item_count} Comments!</div>";
                  ?>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="comments.php">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="far fa-clipboard"></i>
                  </div>
                  <?php
                    $query = "SELECT * FROM categories";
                    $items = mysqli_query($conn, $query);
                    $item_count = mysqli_num_rows($items);
                    
                    echo "<div class='mr-5'>{$item_count} Categories!</div>";
                  ?>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="categories.php">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>

            <div class="col-xl-3 col-sm-6 mb-3">
              <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                  <div class="card-body-icon">
                    <i class="far fa-clipboard"></i>
                  </div>
                  <?php
                    $query = "SELECT * FROM portfolios";
                    $items = mysqli_query($conn, $query);
                    $item_count = mysqli_num_rows($items);
                    
                    echo "<div class='mr-5'>{$item_count} Portfolios!</div>";
                  ?>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="portfolios.php">
                  <span class="float-left">View Details</span>
                  <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                </a>
              </div>
            </div>
            
          </div>

        </div>
        <!-- /.container-fluid -->

        <!-- Footer -->
        <?php include "includes/admin_footer.php"; ?>
          
      </div>
      <!-- /.content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <!-- Scripts -->
    <?php include "includes/admin_scripts.php"; ?>
  </body>
</html>