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

          <h1>Admin Page - TEAM</h1>
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
                <th>Name</th>
                <th>Title</th>
                <th>Date</th>
                <th>Photo</th>
                <th>X</th>
                <th>Facebook</th>
                <th>LinkedIn</th>
                <th><a class='btn btn-large btn-light' href='#' data-toggle='modal' data-target='#add_modal'>Add Employee</a></th>
              </tr>
            </thead>

            <tbody>

              <?php
                if(isset($_POST["add_employee"])){
                  // Escape special characters in input data
                  $employee_id = mysqli_real_escape_string($conn, $_POST["employee_id"]);
                  $employee_name = mysqli_real_escape_string($conn, $_POST["employee_name"]);
                  $employee_title = mysqli_real_escape_string($conn, $_POST["employee_title"]);
                  $employee_img = mysqli_real_escape_string($conn, $_POST["employee_img"]);
                  $employee_x = mysqli_real_escape_string($conn, $_POST["employee_x"]);
                  $employee_facebook = mysqli_real_escape_string($conn, $_POST["employee_facebook"]);
                  $employee_linkedin = mysqli_real_escape_string($conn, $_POST["employee_linkedin"]);

                  $employee_img = $_FILES['employee_img']['name'];
                  $employee_img_tmp = $_FILES['employee_img']['tmp_name'];
                  move_uploaded_file($employee_img_tmp, "../user/img/$employee_img");


                  $sql = "INSERT INTO employees (employee_name, employee_title, employee_img, employee_date, employee_x, employee_facebook, employee_linkedin) 
                                VALUES ('{$employee_name}', '{$employee_title}', '{$employee_img}', now(), '{$employee_x}', '{$employee_facebook}', '{$employee_linkedin}')";

                  $add_employee = mysqli_query($conn, $sql);
          
                  (!$add_employee) ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The employee has been successfully added!";
                  header("Location: employees.php");
                  exit();
                }
              ?>

              <?php
                if(isset($_POST["edit_employee"])){
                  $employee_name = mysqli_real_escape_string($conn, $_POST['employee_name']);
                  $employee_title = mysqli_real_escape_string($conn, $_POST['employee_title']);
                  $employee_x = mysqli_real_escape_string($conn, $_POST['employee_x']);
                  $employee_facebook = mysqli_real_escape_string($conn, $_POST['employee_facebook']);
                  $employee_linkedin = mysqli_real_escape_string($conn, $_POST['employee_linkedin']);

                  $employee_img = $_FILES['employee_img']['name'];
                  $employee_img_tmp = $_FILES['employee_img']['tmp_name'];
                  
                  if(empty($employee_img)){ 
                    $img_query = "SELECT * FROM employees WHERE employee_id = '$_POST[employee_id]'";
                    $select_img = mysqli_query($conn, $img_query);
                    while($img = mysqli_fetch_array($select_img)){
                      $employee_img = $img['employee_img'];
                    }
                  }

                  move_uploaded_file($employee_img_tmp, "../user/img/$employee_img");

                  $edit_query = "UPDATE employees SET employee_name = '$employee_name', employee_title = '$employee_title', employee_x = '$employee_x', employee_facebook = '$employee_facebook', employee_linkedin = '$employee_linkedin', employee_img = '$employee_img' WHERE employee_id = '$_POST[employee_id]'";
                  $edit_employee = mysqli_query($conn, $edit_query);
                  if (!$edit_employee) die("SQL Query Failed: " . mysqli_error($conn));

                  header("Location: employees.php");
                  exit();
                }
              ?>

              <?php
                $sql = "SELECT * FROM employees ORDER BY employee_id DESC";
                $employees = mysqli_query($conn, $sql);

                $num = 1;

                while ($employee = mysqli_fetch_assoc($employees)){
                  $employee_id = $employee['employee_id'];
                  $employee_name = $employee['employee_name'];
                  $employee_title = $employee['employee_title'];
                  $employee_date = date('d-m-Y', strtotime($employee['employee_date']));
                  $employee_img = $employee['employee_img'];
                  $employee_x = $employee['employee_x'];
                  $employee_facebook = $employee['employee_facebook'];
                  $employee_linkedin = $employee['employee_linkedin'];

                  echo "<tr>
                          <td>{$employee_id}</td>
                          <td>{$employee_name}</td>
                          <td>{$employee_title}</td>
                          <td>{$employee_date}</td>
                          <td><img src='../user/img/{$employee_img}' width='80' height='80' /></td>
                          <td>{$employee_x}</td>
                          <td>{$employee_facebook}</td>
                          <td>{$employee_linkedin}</td>
                          <td>
                            <div class='dropdown'>
                              <button id='dropdownMenuButton' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' aria-expanded='false' aria-haspopup='true'>
                                Actions
                              </button>
                              <div class='dropdown-menu'>
                                <a class='dropdown-item' href='#' data-toggle='modal' data-target='#edit_modal$num'>Edit</a>
                                <div class='dropdown-divider'></div>
                                <a class='dropdown-item' href='employees.php?delete={$employee_id}'>Delete</a>
                              </div>
                            </div>
                          </td>
                        </tr>";
              ?>

              <div id="edit_modal<?php echo $num; ?>" class="modal fade">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="employee_name">Name</label>                     
                          <input type="text" class="form-control" name="employee_name" value="<?php echo $employee_name; ?>">
                        </div>
                        <div class="form-group">
                          <label for="employee_title">Title</label>
                          <input type="text" class="form-control" name="employee_title" value="<?php echo $employee_title; ?>">
                        </div>
                        <div class="form-group">
                          <label for="employee_date">Date</label>                     
                          <input readonly type="text" class="form-control" name="employee_date" value="<?php echo $employee_date; ?>">
                        </div>
                        <div class="form-group">
                          <label for="employee_img">Image URL</label>                     
                          <img width="100" src="../user/img/<?php echo $employee_img; ?>">
                          <input type="file" class="form-control" name="employee_img">
                        </div>
                        <div class="form-group">
                          <label for="employee_x">X</label>                     
                          <input type="text" class="form-control" name="employee_x" value="<?php echo $employee_x; ?>">
                        </div>
                        <div class="form-group">
                          <label for="employee_facebook">Facebook</label>                     
                          <input type="text" class="form-control" name="employee_facebook" value="<?php echo $employee_facebook; ?>">
                        </div>
                        <div class="form-group">
                          <label for="employee_linkedin">LinkedIn</label>                     
                          <input type="text" class="form-control" name="employee_linkedin" value="<?php echo $employee_linkedin; ?>">
                        </div>
                        <div class="form-group">
                          <input type="hidden" name="employee_id" value="<?php echo $employee['employee_id']; ?>">
                          <input type="submit" class="btn btn-primary" name="edit_employee" value="Edit Employee">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <?php $num++; } ?>

            </tbody>
          </table>

          <div id="add_modal" class="modal fade">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Employee</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="employee_name">Name</label>                     
                      <input type="text" class="form-control" name="employee_name" required>
                    </div>
                    <div class="form-group">
                      <label for="employee_title">Title</label>
                      <input type="text" class="form-control" name="employee_title" required>
                    </div>
                    <div class="form-group">
                      <label for="employee_img">Image URL</label>                     
                      <input type="file" class="form-control" name="employee_img">
                    </div>
                    <div class="form-group">
                      <label for="employee_x">X</label>                     
                      <input type="text" class="form-control" name="employee_x">
                    </div>
                    <div class="form-group">
                      <label for="employee_facebook">Facebook</label>                     
                      <input type="text" class="form-control" name="employee_facebook">
                    </div>
                    <div class="form-group">
                      <label for="employee_linkedin">LinkedIn</label>                     
                      <input type="text" class="form-control" name="employee_linkedin">
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-primary" name="add_employee" value="Add Employee">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <?php
            if(isset($_GET["delete"])){
              $del_employee_id = $_GET["delete"];

              $del_file_query = "SELECT * FROM posts WHERE post_id = {$del_employee_id} ";
              $del_file = mysqli_query($conn, $del_file_query);
              
              if(!$del_file){ die('SQL query failed!: ' . mysqli_error($conn));}

              // Delete file for a deleted post
              while($img = mysqli_fetch_assoc($del_file)){
                $employee_img = $img['employee_img'];
                unlink("../user/img/$employee_img");
              }

              $del_employee_query = "DELETE FROM employees WHERE employee_id = {$del_employee_id} LIMIT 1";
              $del_employee = mysqli_query($conn, $del_employee_query);
              
              !$del_employee ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The Employee has been successfully deleted!";
              header("Location: employees.php");
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

