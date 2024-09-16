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
                <th>Author</th>
                <th>Email</th>
                <th>Comment</th>
                <th>Date</th>
                <th>Status</th>
                <th>Response</th>
                <th>Add/Edit/Delete</th>
              </tr>
            </thead>

            <tbody>

              <?php
               //  if(isset($_POST["add_post"])){
               //    // Escape special characters in input data
               //    $post_title = mysqli_real_escape_string($conn, $_POST["post_title"]);
               //    $post_category = mysqli_real_escape_string($conn, $_POST["post_category"]);
               //    $post_author = mysqli_real_escape_string($conn, $_POST["post_author"]);
               //    $post_comment_number = mysqli_real_escape_string($conn, $_POST["post_comment_number"]);
               //    $post_text = mysqli_real_escape_string($conn, $_POST["post_text"]);
               //    $post_tags = mysqli_real_escape_string($conn, $_POST["post_tags"]);

               //    $post_img = $_FILES['post_img']['name'];
               //    $post_img_tmp = $_FILES['post_img']['tmp_name'];
               //    move_uploaded_file($post_img_tmp, "../img/$post_img");

               //    if ($post_title == null || empty($post_title)) {
               //      echo "<div class='alert alert-danger' role='alert'>Please, type a title for the post!</div>";
               //    } else if ($post_category == null || empty($post_category)) {
               //      echo "<div class='alert alert-danger' role='alert'>Please, type a category for the post!</div>";
               //    } else if ($post_author == null || empty($post_author)) {
               //      echo "<div class='alert alert-danger' role='alert'>Please, type the author name of the post!</div>";
               //    } else if ($post_text == null || empty($post_text)) {
               //      echo "<div class='alert alert-danger' role='alert'>Please, enter the text of the post!</div>";
               //    } else {
               //        $sql_query = "INSERT INTO posts (post_title, post_category, post_author, post_date, post_comment_number, post_text, post_tags, post_img) 
               //                      VALUES ('{$post_title}', '{$post_category}', '{$post_author}', now(), '{$post_comment_number}', '{$post_text}', '{$post_tags}', '{$post_img}')";

               //        $add_post = mysqli_query($conn, $sql_query);
              
               //        $_SESSION['message'] = "The comment has been successfully added!";
               //        header("Location: comments.php");
               //        exit();
               //    }
               //  }
              ?>

              <?php
               //  if(isset($_POST["edit_post"])){
               //    $post_title = $_POST['post_title'];
               //    $post_category = $_POST['post_category'];
               //    $post_author = $_POST['post_author'];
               //    $post_tags = $_POST['post_tags'];
               //    $post_text = $_POST['post_text'];

               //    $post_img = $_FILES['post_img']['name'];
               //    $post_img_tmp = $_FILES['post_img']['tmp_name'];
                  
               //    if(empty($post_img)){ 
               //      $img_query = "SELECT * FROM posts WHERE post_id = '$_POST[post_id]'";
               //      $select_img = mysqli_query($conn, $img_query);
               //      while($img = mysqli_fetch_array($select_img)){
               //        $post_img = $img['post_img'];
               //      }
               //    }

               //    move_uploaded_file($post_img_tmp, "../img/$post_img");

               //    $edit_query = "UPDATE posts SET post_title = '$post_title', post_category = '$post_category', post_author = '$post_author', post_tags = '$post_tags', post_text = '$post_text', post_img = '$post_img' WHERE post_id = '$_POST[post_id]'";
               //    $edit_post = mysqli_query($conn, $edit_query);

               //    $_SESSION['message'] = "The post has been successfully edited!";
               //    header("Location: posts.php");
               //    exit();
               //  }
              ?>

              <?php
                $sql_query = "SELECT * FROM comments ORDER BY comment_id DESC";
                $comments = mysqli_query($conn, $sql_query);

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

                  while($post = mysqli_fetch_assoc($posts)){
                     $post_id = $post['post_id'];
                     $post_title = $post['post_title'];
                  }

                  echo "   <td>{$post_title}</td>";
                  echo "   <td>
                              <div class='dropdown'>
                                 <button id='dropdownMenuButton' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' aria-expanded='false' aria-haspopup='true'>
                                    Actions
                                 </button>
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
                           <select class="form-control" name="comment_status">
                              <option value='unapproved'>unapproved</option>
                              <option value='approved'>approved</option>
                           </select>
                           <!-- <input type="text" class="form-control" name="comment_status" value="<?php // echo $comment_status; ?>"> -->
                        </div>
                        <div class="form-group">
                          <label for="commented_post">Commented Post</label>                     
                          <input readonly type="text" class="form-control" name="commented_post" value="<?php echo $post_title; ?>">
                        </div>
                        <div class="form-group">
                          <input type="hidden" name="comment_id" value="<?php echo $post['comment_id']; ?>">
                          <input type="submit" class="btn btn-primary" name="view_comment" value="Save">
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
                  <h5 class="modal-title" id="exampleModalLabel">Add Post</h5>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <label for="post_title">Title</label>                     
                      <input type="text" class="form-control" name="post_title">
                    </div>
                    <div class="form-group">
                      <label for="post_category">Category</label>                     
                      <select class="form-control" name="post_category">
                        <?php
                        //   $add_query = "SELECT * FROM categories";
                        //   $categories = mysqli_query($conn, $add_query);

                        //   while($category = mysqli_fetch_assoc($categories)){
                        //       $category_name = $category['category_name'];
                        //       echo "<option value='$category_name'>$category_name</option>";
                        //   }
                        ?>
                    </select>
                    </div>
                    <div class="form-group">
                      <label for="post_author">Author</label>                     
                      <input type="text" class="form-control" name="post_author">
                    </div>
                    <div class="form-group">
                      <label for="post_comment_number">Comment Number</label>                     
                      <input type="text" class="form-control" name="post_comment_number">
                    </div>
                    <div class="form-group">
                      <label for="post_img">Image URL</label>                     
                      <input type="file" class="form-control" name="post_img">
                    </div>
                    <div class="form-group">
                      <label for="post_tags">Tags</label>                     
                      <input type="text" class="form-control" name="post_tags">
                    </div>
                    <div class="form-group">
                      <label for="post_text">Text</label>                     
                      <textarea type="text" class="form-control" name="post_text" cols="20" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-primary" name="add_post" value="Add Post">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <?php
            if(isset($_GET["approve"])){
              $approve_comment_id = $_GET["approve"];
              $sql_query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$approve_comment_id}";
              $approve_comment = mysqli_query($conn, $sql_query);
              
              $_SESSION['message'] = "The Comment has been successfully approved!";
              header("Location: comments.php");
              exit();
            }

            if(isset($_GET["unapprove"])){
               $unapprove_comment_id = $_GET["unapprove"];
               $sql_query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$unapprove_comment_id}";
               $unapprove_comment = mysqli_query($conn, $sql_query);
               
               $_SESSION['message'] = "The Comment has been successfully unapproved!";
               header("Location: comments.php");
               exit();
             }
          ?>

          <?php
            if(isset($_GET["delete"])){
              $del_comment_id = $_GET["delete"];
              $sql_query = "DELETE FROM comments WHERE comment_id = {$del_comment_id} ";
              $del_comment = mysqli_query($conn, $sql_query);
              
              $_SESSION['message'] = "The Comment has been successfully deleted!";
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

