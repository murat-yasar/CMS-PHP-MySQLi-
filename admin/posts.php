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
                <th>Post Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Date</th>
                <th>Comments</th>
                <th>Image</th>
                <th>Text</th>
                <th>Tags</th>
                <th>Add/Edit/Delete</th>
              </tr>
            </thead>

            <tbody>

              <?php
                if(isset($_POST["add_post"])){
                  $post_title = $_POST["post_title"];
                  $post_category = $_POST["post_category"];
                  $post_author = $_POST["post_author"];
                  $post_comment_number = $_POST["post_comment_number"];
                  $post_text = $_POST["post_text"];
                  $post_tags = $_POST["post_tags"];
                  $post_date = date('d-m-y');

                  $post_img_url = $_FILES['post_img_url']['name'];
                  $post_img_url_tmp = $_FILES['post_img_url']['tmp_name'];
                  move_uploaded_file($post_img_url_tmp, "../img/$post_img_url");

                  if ($post_title == null || empty($post_title)){
                    echo "<div class='alert alert-danger' role='alert'>Please, type a title for the post!</div>";
                  } else {
                    $sql_query = "INSERT INTO posts (post_title, post_category, post_author, post_date, post_comment_number, post_text, post_tags, post_image_url) 
                                  VALUES ('{$post_title}', '{$post_category}', '{$post_author}', now(), '{$post_comment_number}', '{$post_text}', '{$post_tags}', '{$post_img_url}')";
                    $add_post = mysqli_query($conn, $sql_query);

                    $_SESSION['message'] = "The post has been successfully added!";
                    header("Location: posts.php");
                    exit();
                  }
                }
              ?>

              <?php
               //  if(isset($_POST["edit_category"])){
               //    $edit_cat_title = $_POST["category_name_edit"];
               //    $sql_query_edit = "UPDATE categories SET category_name = '$edit_cat_title' WHERE category_id = '$_POST[category_id]'";
               //    $edit_category_query = mysqli_query($conn, $sql_query_edit);

               //    $_SESSION['message'] = "The category has been successfully edited!";
               //    header("Location: categories.php");
               //    exit();
               //  }
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
                  $post_date = $post['post_date'];
                  $post_comment_number = $post['post_comment_number'];
                  $post_img_url = $post['post_image_url'];
                  $post_text = substr($post['post_text'], 0, 50);
                  $post_tags = $post['post_tags'];

                  echo "<tr>
                          <td>{$post_id}</td>
                          <td>{$post_title}</td>
                          <td>{$post_category}</td>
                          <td>{$post_author}</td>
                          <td>{$post_date}</td>
                          <td>{$post_comment_number}</td>
                          <td><img src='../img/{$post_img_url}' width='80' height='80' /></td>
                          <td>{$post_text}</td>
                          <td>{$post_tags}</td>
                          <td>
                            <div class='dropdown'>
                              <button id='dropdownMenuButton' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' aria-expanded='false' aria-haspopup='true'>
                                Actions
                              </button>
                              <div class='dropdown-menu'>
                                <a class='dropdown-item' href='#' data-toggle='modal' data-target='#add_modal'>Add</a>
                                <div class='dropdown-divider'></div>
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
                          <input type="text" class="form-control" name="post_title_edit" value="<?php if(isset($post_title)) echo $post_title; ?>">
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
                      <input type="text" class="form-control" name="post_title">
                    </div>
                    <div class="form-group">
                      <label for="post_category">Category</label>                     
                      <input type="text" class="form-control" name="post_category">
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
                      <label for="post_img_url">Image URL</label>                     
                      <input type="file" class="form-control" name="post_img_url">
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
            if(isset($_GET["delete"])){
              $del_post_id = $_GET["delete"];
              $sql_query = "DELETE FROM posts WHERE post_id = {$del_post_id} ";
              $del_post = mysqli_query($conn, $sql_query);
              
              $_SESSION['message'] = "The Post has been successfully deleted!";
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

