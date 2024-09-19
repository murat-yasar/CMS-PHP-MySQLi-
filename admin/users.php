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
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Role</th>
                <th><a class='btn btn-large btn-light' href='#' data-toggle='modal' data-target='#add_modal'>Add User</a></th>
              </tr>
            </thead>

            <tbody>

              <?php
                if(isset($_POST["add_user"])){
                  // Escape special characters in input data
                  $user_name = mysqli_real_escape_string($conn, $_POST["user_name"]);
                  $user_email = mysqli_real_escape_string($conn, $_POST["user_email"]);
                  $user_role = mysqli_real_escape_string($conn, $_POST["user_role"]);
                  $user_password = mysqli_real_escape_string($conn, $_POST["user_password"]);

                  $sql_query = "INSERT INTO users (user_name, user_email, user_role, user_password) VALUES ('{$user_name}', '{$user_email}', '{$user_role}', '{$user_password}')";

                  $add_user = mysqli_query($conn, $sql_query);

                  !$add_user ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The user has been successfully added!";
          
                  header("Location: users.php");
                  exit();
                }
              ?>

              <?php
                if(isset($_POST["edit_user"])){
                  $user_id = $_POST['user_id'];
                  $user_name = $_POST['user_name'];
                  $user_email = $_POST['user_email'];
                  $user_role = $_POST['user_role'];
                  $user_password = $_POST['user_password'];

                  $edit_query = "UPDATE users SET user_name = '$user_name', user_email = '$user_email', user_role = '$user_role', user_password = '$user_password' WHERE user_id = '$_POST[user_id]'";
                  $edit_user = mysqli_query($conn, $edit_query);

                  !$edit_user ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The user has been successfully edited!";
                  header("Location: users.php");
                  exit();
                }
              ?>

              <?php
                $sql_query = "SELECT * FROM users ORDER BY user_id DESC";
                $users = mysqli_query($conn, $sql_query);

                $num = 1;

                while ($user = mysqli_fetch_assoc($users)){
                  $user_id = $user['user_id'];
                  $user_name = $user['user_name'];
                  $user_password = $user['user_password'];
                  $user_email = $user['user_email'];
                  $user_role = $user['user_role'];

                  echo "<tr>
                          <td>{$user_id}</td>
                          <td>{$user_name}</td>
                          <td>{$user_email}</td>
                          <td>{$user_role}</td>
                          <td>{$user_password}</td>
                          <td>
                            <div class='dropdown'>
                              <button id='dropdownMenuButton' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' aria-expanded='false' aria-haspopup='true'>
                                Actions
                              </button>
                              <div class='dropdown-menu'>
                                <a class='dropdown-item' href='#' data-toggle='modal' data-target='#edit_modal$num'>Edit</a>
                                <div class='dropdown-divider'></div>
                                <a class='dropdown-item' href='users.php?delete={$user_id}'>Delete</a>
                              </div>
                            </div>
                          </td>
                        </tr>";
              ?>

              <div id="edit_modal<?php echo $num; ?>" class="modal fade">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="user_name">User Name</label>                     
                          <input type="text" class="form-control" name="user_name" value="<?php echo $user_name; ?>" required>
                        </div>
                        <div class="form-group">
                          <label for="user_email">User Email</label>                     
                          <input type="email" class="form-control" name="user_email" value="<?php echo $user_email; ?>" required>
                        </div>
                        <div class="form-group">
                          <label for="user_password">User Password</label>                     
                          <input type="password" class="form-control" name="user_password" value="<?php echo $user_password; ?>">
                        </div>
                        <div class="form-group">
                          <label for="user_role">User Role</label>                     
                          <select class="form-control" name="user_role">
                            <?php
                              echo ($user_role == 'admin') ? "<option value='admin' selected>Admin</option> <option value='member'>Member</option>" : "<option value='admin'>Admin</option> <option value='member' selected>Member</option>";
                            ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                          <input type="submit" class="btn btn-primary" name="edit_user" value="Edit User">
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
                  <h5 class="modal-title" id="exampleModalLabel">Add User</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="user_name">User Name</label>
                      <input type="text" class="form-control" name="user_name" required>
                    </div>
                    <div class="form-group">
                      <label for="user_email">User Email</label>
                      <input type="email" class="form-control" name="user_email" required>
                    </div>
                    <div class="form-group">
                      <label for="user_password">User Password</label>
                      <input type="password" class="form-control" name="user_password" required>
                    </div>
                    <div class="form-group">
                      <label for="user_role">User Role</label>
                      <select name="user_role">
                        <option value='member' selected>Member</option>
                        <option value='admin'>Admin</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-primary" name="add_user" value="Add User">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <?php
            if(isset($_GET["delete"])){
              $del_user_id = $_GET["delete"];
              $sql_query = "DELETE FROM users WHERE user_id = {$del_user_id} ";
              $del_user = mysqli_query($conn, $sql_query);
              
              !$del_user ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The User has been successfully deleted!";
              header("Location: users.php");
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

