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

          <h1>Admin Page - Posts</h1>
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
                <th>Post Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Date</th>
                <th>Comments</th>
                <th>Image</th>
                <th>Text</th>
                <th>Tags</th>
                <th><a class='btn btn-large btn-light' href='#' data-toggle='modal' data-target='#add_modal'>Add Post</a></th>
              </tr>
            </thead>

            <tbody>

              <?php
                if(isset($_POST["add_post"])){
                  // Escape special characters in input data
                  $post_title = mysqli_real_escape_string($conn, $_POST["post_title"]);
                  $post_category = mysqli_real_escape_string($conn, $_POST["post_category"]);
                  $post_author = mysqli_real_escape_string($conn, $_POST["post_author"]);
                  $post_text = mysqli_real_escape_string($conn, $_POST["post_text"]);
                  $post_tags = mysqli_real_escape_string($conn, $_POST["post_tags"]);

                  $post_img = $_FILES['post_img']['name'];
                  $post_img_tmp = $_FILES['post_img']['tmp_name'];
                  move_uploaded_file($post_img_tmp, "../img/$post_img");


                  $sql_query = "INSERT INTO posts (post_title, post_category, post_author, post_date, post_text, post_tags, post_img) 
                                VALUES ('{$post_title}', '{$post_category}', '{$post_author}', now(), '{$post_text}', '{$post_tags}', '{$post_img}')";

                  $add_post = mysqli_query($conn, $sql_query);
          
                  !$add_post ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The post has been successfully added!";
                  header("Location: posts.php");
                  exit();
                }
              ?>

              <?php
                if(isset($_POST["edit_post"])){
                  $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
                  $post_category = mysqli_real_escape_string($conn, $_POST['post_category']);
                  $post_author = mysqli_real_escape_string($conn, $_POST['post_author']);
                  $post_tags = mysqli_real_escape_string($conn, $_POST['post_tags']);
                  $post_text = mysqli_real_escape_string($conn, $_POST['post_text']);

                  $post_img = $_FILES['post_img']['name'];
                  $post_img_tmp = $_FILES['post_img']['tmp_name'];
                  
                  if(empty($post_img)){ 
                    $img_query = "SELECT * FROM posts WHERE post_id = '$_POST[post_id]'";
                    $select_img = mysqli_query($conn, $img_query);
                    while($img = mysqli_fetch_array($select_img)){
                      $post_img = $img['post_img'];
                    }
                  }

                  move_uploaded_file($post_img_tmp, "../img/$post_img");

                  $edit_query = "UPDATE posts SET post_title = '$post_title', post_category = '$post_category', post_author = '$post_author', post_tags = '$post_tags', post_text = '$post_text', post_img = '$post_img' WHERE post_id = '$_POST[post_id]'";
                  $edit_post = mysqli_query($conn, $edit_query);

                  !$edit_post ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The post has been successfully edited!";
                  header("Location: posts.php");
                  exit();
                }
              ?>

              <?php
                $sql_query = "SELECT * FROM posts ORDER BY post_id DESC";
                $posts = mysqli_query($conn, $sql_query);

                $num = 1;

                while ($post = mysqli_fetch_assoc($posts)){
                  $post_id = $post['post_id'];
                  $post_category = $post['post_category'];
                  $post_title = $post['post_title'];
                  $post_author = $post['post_author'];
                  $post_date = date('d-m-Y', strtotime($post['post_date']));
                  $post_img = $post['post_img'];
                  $post_text = substr($post['post_text'], 0, 50);
                  $post_tags = $post['post_tags'];

                  $comments_query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} AND comment_status = 'approved'";
                  $comments = mysqli_query($conn, $comments_query);
                  $post_comments_count = mysqli_num_rows($comments);

                  echo "<tr>
                          <td>{$post_id}</td>
                          <td>{$post_title}</td>
                          <td>{$post_category}</td>
                          <td>{$post_author}</td>
                          <td>{$post_date}</td>
                          <td>{$post_comments_count}</td>
                          <td><img src='../img/{$post_img}' width='80' height='80' /></td>
                          <td>{$post_text}</td>
                          <td>{$post_tags}</td>
                          <td>
                            <div class='dropdown'>
                              <button id='dropdownMenuButton' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' aria-expanded='false' aria-haspopup='true'>
                                Actions
                              </button>
                              <div class='dropdown-menu'>
                                <a class='dropdown-item' href='#' data-toggle='modal' data-target='#edit_modal$num'>Edit</a>
                                <div class='dropdown-divider'></div>
                                <a class='dropdown-item' href='posts.php?delete={$post_id}'>Delete</a>
                              </div>
                            </div>
                          </td>
                        </tr>";
              ?>

              <div id="edit_modal<?php echo $num; ?>" class="modal fade">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Post</h5>
                      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="post_title">Title</label>                     
                          <input type="text" class="form-control" name="post_title" value="<?php echo $post_title; ?>">
                        </div>
                        <div class="form-group">
                          <label for="post_category">Category</label>                     
                          <select class="form-control" name="post_category">
                            <?php
                              $sql_query = "SELECT * FROM categories";
                              $categories = mysqli_query($conn, $sql_query);

                              while($category = mysqli_fetch_assoc($categories)){
                                  $category_name = $category['category_name'];
                                  echo ($category_name == $post_category) ? "<option value='$category_name' selected>$category_name</option>" : "<option value='$category_name'>$category_name</option>";
                              }
                            ?>
                        </select>
                        </div>
                        <div class="form-group">
                          <label for="post_author">Author</label>                     
                          <input type="text" class="form-control" name="post_author" value="<?php echo $post_author; ?>">
                        </div>
                        <div class="form-group">
                          <label for="post_img">Image URL</label>
                          <img width="100" src="../img/<?php echo $post_img; ?>">
                          <input type="file" class="form-control" name="post_img">
                        </div>
                        <div class="form-group">
                          <label for="post_tags">Tags</label>
                          <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
                        </div>
                        <div class="form-group">
                          <label for="post_text">Text</label>
                          <textarea type="text" class="form-control" name="post_text" cols="20" rows="5"><?php echo $post['post_text']; ?></textarea>
                        </div>
                        <div class="form-group">
                          <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                          <input type="submit" class="btn btn-primary" name="edit_post" value="Edit Post">
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
                      <input type="text" class="form-control" name="post_title" required>
                    </div>
                    <div class="form-group">
                      <label for="post_category">Category</label>                     
                      <select class="form-control" name="post_category">
                        <?php
                          $add_query = "SELECT * FROM categories";
                          $categories = mysqli_query($conn, $add_query);

                          while($category = mysqli_fetch_assoc($categories)){
                              $category_name = $category['category_name'];
                              echo "<option value='$category_name'>$category_name</option>";
                          }
                        ?>
                    </select>
                    </div>
                    <div class="form-group">
                      <label for="post_author">Author</label>                     
                      <input type="text" class="form-control" name="post_author" required>
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
                      <textarea type="text" class="form-control" name="post_text" cols="20" rows="5" required></textarea>
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
            if(isset($_GET["delete"])){
              $del_post_id = $_GET["delete"];

              $del_file_query = "SELECT * FROM posts WHERE post_id = {$del_post_id} ";
              $del_file = mysqli_query($conn, $del_file_query);
              
              if(!$del_file){ die('SQL query failed!: ' . mysqli_error($conn));}

              // Delete file for a deleted post
              while($img = mysqli_fetch_assoc($del_file)){
                $post_img = $img['post_img'];
                unlink("../img/$post_img");
              }

              $del_post_query = "DELETE FROM posts WHERE post_id = {$del_post_id} ";
              $del_post = mysqli_query($conn, $del_post_query);
              if(!$del_post){ die('SQL query failed!: ' . mysqli_error($conn));}


              // TODO: Add another script for the comments! If you delete a post, all the comments refering to that post, must be deleted, as well!
              
              !$del_post ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The Post has been successfully deleted!";
              header("Location: posts.php");
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

