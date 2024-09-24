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

          <h1>Admin Page - Comments</h1>
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
                <th>Author</th>
                <th>Email</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Status</th>
                <th>Response</th>
                <th>Actions</th>
              </tr>
            </thead>

            <tbody>

              <?php
                $sql_query = "SELECT * FROM comments ORDER BY comment_id DESC";
                $comments = mysqli_query($conn, $sql_query);
                !$comments ? die("SQL Query Failed: " . mysqli_error($conn)) : null;

                $num = 1;

                while ($comment = mysqli_fetch_assoc($comments)){
                  $comment_id = $comment['comment_id'];
                  $comment_post_id = $comment['comment_post_id'];
                  $comment_author = $comment['comment_author'];
                  $comment_email = $comment['comment_email'];
                  $comment_text = $comment['comment_text'];
                  $comment_date = date('d-m-Y', strtotime($comment['comment_date']));
                  $comment_status = $comment['comment_status'];

                  echo "<tr>
                          <td>{$comment_id}</td>
                          <td>{$comment_author}</td>
                          <td>{$comment_email}</td>
                          <td>{$comment_text}</td>
                          <td>{$comment_date}</td>
                          <td>{$comment_status}</td>";

                  $sql_query = "SELECT * FROM posts WHERE post_id = $comment_post_id";
                  $posts = mysqli_query($conn, $sql_query);
                  !$comments ? die("SQL Query Failed: " . mysqli_error($conn)) : null;

                  while($post = mysqli_fetch_assoc($posts)){
                     $post_id = $post['post_id'];
                     $post_title = $post['post_title'];
                     
                     echo "   <td>{$post_title}</td>";
                     echo "   <td>
                                <div class='dropdown'>
                                  <button id='dropdownMenuButton' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' aria-expanded='false' aria-haspopup='true'>Actions</button>
                                  <div class='dropdown-menu'>
                                    <a class='dropdown-item' href='#' data-toggle='modal' data-target='#view_modal$num'>View</a>
                                    <div class='dropdown-divider'></div>
                                    <a class='dropdown-item' href='comments.php?approve={$comment_id}'>Approve</a>
                                    <div class='dropdown-divider'></div>
                                    <a class='dropdown-item' href='comments.php?unapprove={$comment_id}'>Unapprove</a>
                                    <div class='dropdown-divider'></div>
                                    <a class='dropdown-item' href='comments.php?delete={$comment_id}'>Delete</a>
                                  </div>
                                </div>
                              </td>
                            </tr>";
                     }
              ?>

              <div id="view_modal<?php echo $num; ?>" class="modal fade">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">View Comment</h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="comment_author">Comment Author</label>                     
                          <input readonly type="text" class="form-control" name="comment_author" value="<?php echo $comment_author; ?>">
                        </div>
                        <div class="form-group">
                          <label for="comment_email">Comment E-Mail</label>                     
                          <input readonly type="email" class="form-control" name="comment_email" value="<?php echo $comment_email; ?>">
                        </div>
                        <div class="form-group">
                          <label for="comment_text">Comment Text</label>
                          <textarea readonly type="text" class="form-control" name="comment_text" cols="20" rows="5"><?php echo $comment_text; ?></textarea>
                        </div>
                        <div class="form-group">
                           <label for="comment_status">Comment Status</label>
                           <input type="text" class="form-control" name="comment_status" value="<?php if(isset($comment_status)) echo $comment_status; ?>">
                        </div>
                        <div class="form-group">
                          <label for="commented_post">Commented Post</label>                     
                          <input readonly type="text" class="form-control" name="commented_post" value="<?php echo $post_title; ?>">
                        </div>
                        <div class="form-group">
                          <input type="hidden" name="comment_id" value="<?php echo $post['comment_id']; ?>">
                          <input type="submit" class="btn btn-primary" name="view_comment" value="Close">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>

              <?php $num++; } ?>

            </tbody>
          </table>

          <?php
            if(isset($_GET["approve"])){
              $approve_comment_id = $_GET["approve"];
              $approve_query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$approve_comment_id}";
              $approve_comment = mysqli_query($conn, $approve_query);
              
              !$approve_comment ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The Comment has been successfully approved!";
              header("Location: comments.php");
              exit();
            }

            if(isset($_GET["unapprove"])){
               $unapprove_comment_id = $_GET["unapprove"];
               $sql_query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$unapprove_comment_id}";
               $unapprove_comment = mysqli_query($conn, $sql_query);
               
               !$unapprove_comment ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The Comment has been successfully unapproved!";
               header("Location: comments.php");
               exit();
             }
          ?>

          <?php
            if(isset($_GET["delete"])){
              $del_comment_id = $_GET["delete"];
              $sql_query = "DELETE FROM comments WHERE comment_id = {$del_comment_id} ";
              $del_comment = mysqli_query($conn, $sql_query);
              
              !$del_comment ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The Comment has been successfully deleted!";
              header("Location: comments.php");
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

