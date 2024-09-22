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
                    $_SESSION['post_count'] = $item_count;
                    
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
                    $_SESSION['comment_count'] = $item_count;
                    
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
                    $_SESSION['category_count'] = $item_count;
                    
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
                    $_SESSION['portfolio_count'] = $item_count;
                    
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
          <!-- /.row -->

          <hr>

          <div class="row">

            <!-- Column Chart -->
            <div class="col-md-6">
              <script type="text/javascript">
                google.charts.load('current', {'packages':['bar']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                  var data = google.visualization.arrayToDataTable([
                    ['Information', '', '', '', ''],
                    ['Posts', <?php echo $_SESSION['post_count']; ?>, 0, 0, 0],
                    ['Comments', 0, <?php echo $_SESSION['comment_count']; ?>, 0, 0],
                    ['Categories', 0, 0, <?php echo $_SESSION['category_count']; ?>, 0],
                    ['Portfolios', 0, 0, 0, <?php echo $_SESSION['portfolio_count']; ?>]
                  ]);

                  var options = {
                    chart: {
                      title: '',
                      subtitle: '',
                    }
                  };

                  var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                  chart.draw(data, google.charts.Bar.convertOptions(options));
                }
              </script>
              <div id="columnchart_material" style="width: auto; height: 400px;"></div>
            </div>

            <!-- Pie Chart -->
            <?php
              $query = "SELECT * FROM comments WHERE comment_status = 'approved'";
              $items = mysqli_query($conn, $query);
              $approve_count = mysqli_num_rows($items);
            ?>

            <div class="col-md-6">
              <script type="text/javascript">
                google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {

                  var data = google.visualization.arrayToDataTable([
                    ['Comments', 'Status'],
                    ['Approved', <?php echo $approve_count; ?>],
                    ['Unapproved', <?php echo $_SESSION['comment_count'] - $approve_count; ?>]
                  ]);

                  var options = {
                    title: 'Comments'
                  };

                  var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                  chart.draw(data, options);
                }
              </script>
              <div id="piechart" style="width: auto; height: 400px;"></div>
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