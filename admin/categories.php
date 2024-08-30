
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

          <table class="table table bordered">
            <thead class="thead-dark">
              <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Add - Edit - Delete</th>
              </tr>
            </thead>

            <tbody>

            <?php
              $sql_query = "SELECT * FROM categories";
              $categories = mysqli_query($conn, $sql_query);

              while ($category = mysqli_fetch_assoc($categories)){
                $category_id = $category['category_id'];
                $category_name = $category['category_name'];

                echo "
                <tr>
                  <td>{$category_id}</td>
                  <td>{$category_name}</td>
                  <td>
                    <div class='dropdown'>
                      <button id='dropdownMenuButton' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' aria-expanded='false' aria-haspopup='true'>
                        Actions
                      </button>
                      <div class='dropdown-menu'>
                        <a class='dropdown-item' href='#' data-toggle='modal' data-target='#add_modal'>Add</a>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='#' data-toggle='modal' data-target='#edit_modal'>Edit</a>
                        <div class='dropdown-divider'></div>
                        <a class='dropdown-item' href='#'>Delete</a>
                      </div>
                    </div>
                  </td>
                </tr>
                ";
              }

            ?>

            </tbody>
          </table>

          <div id="edit_modal" class="modal fade">
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
                      <input type="text" class="form-control" name="category_name" value="">
                    </div>
                    <div class="form-group">
                      <input type="hidden" value="" name="category_id">
                      <input type="submit" class="btn btn-primary" name="edit_category" value="Edit Category">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

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

        </div> <!-- /.container-fluid -->

        <!-- Footer -->
        <?php include "includes/admin_footer.php"; ?>
          
      </div> <!-- /.content-wrapper -->
    </div><!-- /#wrapper -->

    <!-- Scripts -->
    <?php include "includes/admin_scripts.php"; ?>
  </body>
</html>