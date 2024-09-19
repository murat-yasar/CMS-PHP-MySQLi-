<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

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

          <h1>Welcome to Admin Page</h1>
          <hr>

          <?php if (isset($_SESSION['message'])): ?>
              <div class='alert alert-success' role='alert'>
                <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
              </div>
          <?php endif; ?>

          <table class="table table bordered">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th><a class='btn btn-large btn-light' href='#' data-toggle='modal' data-target='#add_modal'>Add Category</a></th>
              </tr>
            </thead>

            <tbody>

              <?php
                if(isset($_POST["add_category"])){
                  $category_name = $_POST["category_name"];
                  if ($category_name == null || empty($category_name)){
                    echo "<div class='alert alert-danger' role='alert'>Please, type a category name!</div>";
                  } else {
                    $sql_query = "INSERT INTO categories(category_name) VALUE('$category_name') ";
                    $add_category = mysqli_query($conn, $sql_query);

                    !$add_category ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The category has been successfully added!";
                    header("Location: categories.php");
                    exit();
                  }
                }
              ?>

              <?php
                if(isset($_POST["edit_category"])){
                  $edit_category_name = $_POST["category_name_edit"];
                  $edit_query = "UPDATE categories SET category_name = '$edit_category_name' WHERE category_id = '$_POST[category_id]'";
                  $edit_category = mysqli_query($conn, $edit_query);

                  !$edit_category ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The category has been successfully edited!";
                  header("Location: categories.php");
                  exit();
                }
              ?>

              <?php
                $sql_query = "SELECT * FROM categories ORDER BY category_id DESC";
                $categories = mysqli_query($conn, $sql_query);

                $model_num = 1;

                while ($category = mysqli_fetch_assoc($categories)){
                  $category_id = $category['category_id'];
                  $category_name = $category['category_name'];

                  echo "<tr>
                          <td>{$category_id}</td>
                          <td>{$category_name}</td>
                          <td>
                            <div class='dropdown'>
                              <button id='dropdownMenuButton' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' aria-expanded='false' aria-haspopup='true'>
                                Actions
                              </button>
                              <div class='dropdown-menu'>
                                <a class='dropdown-item' href='#' data-toggle='modal' data-target='#edit_modal$model_num'>Edit</a>
                                <div class='dropdown-divider'></div>
                                <a class='dropdown-item' href='categories.php?delete={$category_id}'>Delete</a>
                              </div>
                            </div>
                          </td>
                        </tr>";
              ?>

              <div id="edit_modal<?php echo $model_num; ?>" class="modal fade">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="" method="post">
                        <div class="form-group">
                          <input type="text" class="form-control" name="category_name_edit" value="<?php if(isset($category_name)) echo $category_name; ?>">
                        </div>
                        <div class="form-group">
                          <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>">
                          <input type="submit" class="btn btn-primary" name="edit_category" value="Edit Category">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <?php $model_num++; } ?>

            </tbody>
          </table>

          <div id="add_modal" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="" method="post">
                    <div class="form-group">
                      <input type="text" class="form-control" name="category_name">
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-primary" name="add_category" value="Add Category">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <?php
            if(isset($_GET["delete"])){
              $del_category_id = $_GET["delete"];
              $sql_query = "DELETE FROM categories WHERE category_id = {$del_category_id} ";
              $del_category = mysqli_query($conn, $sql_query);
              
              !$del_category ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The category has been successfully deleted!";
              header("Location: categories.php");
              exit();
            }
          ?>

        </div> <!-- /.container-fluid -->

        <!-- Footer -->
        <?php include "includes/admin_footer.php"; ?>
          
      </div> <!-- /.content-wrapper -->
    </div><!-- /#wrapper -->

    <!-- Scripts -->
    <?php include "includes/admin_scripts.php"; ?>
  </body>
</html>

