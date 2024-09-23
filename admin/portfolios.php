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

               <h1>Admin Page - Portfolios</h1>
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
                        <th>Portfolio Name</th>
                        <th>Portfolio Category</th>
                        <th>Image (SM)</th>
                        <th>Image (BG)</th>
                        <th><a class='btn btn-large btn-light' href='#' data-toggle='modal' data-target='#add_modal'>Add Portfolio</a></th>
                     </tr>
                  </thead>

                  <tbody>
                     <?php
                        if(isset($_POST['add_portfolio'])){
                           $portfolio_name = $_POST['portfolio_name'];
                           $portfolio_category = $_POST['portfolio_category'];

                           $portfolio_img_sm = $_FILES['portfolio_image_sm']['name'];
                           $portfolio_img_sm_tmp = $_FILES['portfolio_image_sm']['tmp_name'];
                           move_uploaded_file($portfolio_img_sm_tmp, "../img/$portfolio_img_sm");
                           
                           $portfolio_img_bg = $_FILES['portfolio_image_bg']['name'];
                           $portfolio_img_bg_tmp = $_FILES['portfolio_image_bg']['tmp_name'];
                           move_uploaded_file($portfolio_img_bg_tmp, "../img/$portfolio_img_bg");

                           $sql_query = "INSERT INTO portfolios (portfolio_name, portfolio_category, portfolio_img_sm, portfolio_img_bg)
                                          VALUES ('{$portfolio_name}', '{$portfolio_category}', '{$portfolio_img_sm}', '{$portfolio_img_bg}')";

                           $add_portfolio = mysqli_query($conn, $sql_query);

                           !$add_portfolio ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The portfolio has been successfully added!";
                           header("Location: portfolios.php");
                           exit();
                        }
                     ?>

                     <?php
                        if(isset($_POST["edit_portfolio"])){
                           $portfolio_id = $_POST['portfolio_id'];
                           $portfolio_name = $_POST['portfolio_name'];
                           $portfolio_category = $_POST['portfolio_category'];

                           $portfolio_img_sm = $_FILES['portfolio_image_sm']['name'];
                           $portfolio_img_sm_tmp = $_FILES['portfolio_image_sm']['tmp_name'];
                           $portfolio_img_bg = $_FILES['portfolio_image_bg']['name'];
                           $portfolio_img_bg_tmp = $_FILES['portfolio_image_bg']['tmp_name'];

                           if(empty($portfolio_img_sm)){ 
                              $img_sm_query = "SELECT * FROM portfolios WHERE portfolio_id = '$_POST[portfolio_id]'";
                              $select_img_sm = mysqli_query($conn, $img_sm_query);
                              while($img = mysqli_fetch_array($select_img_sm)){
                                 $portfolio_img_sm = $img['portfolio_img_sm'];
                              }
                           }
                           
                           if(empty($portfolio_img_bg)){ 
                              $img_bg_query = "SELECT * FROM portfolios WHERE portfolio_id = '$_POST[portfolio_id]'";
                              $select_img_bg = mysqli_query($conn, $img_bg_query);
                              while($img = mysqli_fetch_array($select_img_bg)){
                                 $portfolio_img_bg = $img['portfolio_img_bg'];
                              }
                           }

                           move_uploaded_file($portfolio_img_sm_tmp, "../img/$portfolio_img_sm");
                           move_uploaded_file($portfolio_img_bg_tmp, "../img/$portfolio_img_bg");

                           $edit_query = "UPDATE portfolios SET portfolio_name = '{$portfolio_name}', portfolio_category = '{$portfolio_category}', portfolio_img_sm = '{$portfolio_img_sm}', portfolio_img_bg = '{$portfolio_img_bg}' WHERE portfolio_id = '{$portfolio_id}'";

                           $edit_portfolio = mysqli_query($conn, $edit_query);
                           
                           !$edit_portfolio ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The portfolio has been successfully edited!";
                           header("Location: portfolios.php");
                           exit();
                        } 

                     ?>


                     <?php
                        $list_query = "SELECT * FROM portfolios ORDER BY portfolio_id DESC";
                        $portfolios = mysqli_query($conn, $list_query);

                        $model_num = 1;

                        while ($portfolio = mysqli_fetch_assoc($portfolios)){
                           $portfolio_id = $portfolio['portfolio_id'];
                           $portfolio_name = $portfolio['portfolio_name'];
                           $portfolio_category = $portfolio['portfolio_category'];
                           $portfolio_img_sm = $portfolio['portfolio_img_sm'];
                           $portfolio_img_bg = $portfolio['portfolio_img_bg'];

                           echo "<tr>
                                    <td>{$portfolio_id}</td>
                                    <td>{$portfolio_name}</td>
                                    <td>{$portfolio_category}</td>
                                    <td><img src='../img/{$portfolio_img_sm}' width='80' height='80' /></td>
                                    <td><img src='../img/{$portfolio_img_bg}' width='80' height='80' /></td>
                                    <td>
                                       <div class='dropdown'>
                                          <button id='dropdownMenuButton' class='btn btn-primary dropdown-toggle' type='button' data-toggle='dropdown' aria-expanded='false' aria-haspopup='true'>
                                             Actions
                                          </button>
                                          <div class='dropdown-menu'>
                                          <a class='dropdown-item' href='#' data-toggle='modal' data-target='#edit_modal$model_num'>Edit</a>
                                          <div class='dropdown-divider'></div>
                                          <a class='dropdown-item' href='portfolios.php?delete={$portfolio_id}'>Delete</a>
                                          </div>
                                       </div>
                                    </td>
                                 </tr>";
                     ?>

                     <div id="edit_modal<?php echo $model_num; ?>" class="modal fade">
                        <div class="modal-dialog" role="document">
                           <div class="modal-content">
                              <div class="modal-header">
                                 <h5 class="modal-title" id="exampleModalLabel">Edit Portfolio</h5>
                                 <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                 </button>
                              </div>
                              <div class="modal-body">
                                 <form action="" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                       <label for="portfolio_name">Portfolio Name</label>
                                       <input type="text" class="form-control" name="portfolio_name" value="<?php echo $portfolio_name; ?>">
                                    </div>
                                    <div class="form-group">
                                       <label for="portfolio_category">Portfolio Category</label>
                                       <select class="form-control" name="portfolio_category">
                                          <?php
                                             $sql_query = "SELECT * FROM categories";
                                             $categories = mysqli_query($conn, $sql_query);

                                             while($category = mysqli_fetch_assoc($categories)){
                                                $category_name = $category['category_name'];
                                                echo ($category_name == $portfolio_category) ? "<option value='$category_name' selected>$category_name</option>" : "<option value='$category_name'>$category_name</option>";
                                             }
                                          ?>
                                       </select>
                                    </div>
                                    <div class="form-group">
                                       <label for="portfolio_image_sm">Small Image: </label><br>
                                       <img width="100" src="../img/<?php echo $portfolio_img_sm; ?>">
                                       <span><?php echo $portfolio_img_sm; ?></span>
                                       <input type="file" class="form-control" name="portfolio_image_sm" value="">
                                    </div>
                                    <div class="form-group">
                                       <label for="portfolio_image_bg">Big Image: </label><br>
                                       <img width="100" src="../img/<?php echo $portfolio_img_bg; ?>">
                                       <span><?php echo $portfolio_img_bg; ?></span>
                                       <input type="file" class="form-control" name="portfolio_image_bg" value="">
                                    </div>
                                    <div class="form-group">
                                       <input type="hidden" name="portfolio_id" value="<?php echo $portfolio_id; ?>">
                                       <input type="submit" class="btn btn-primary" name="edit_portfolio" value="Edit Portfolio">
                                    </div>
                                 </form>
                              </div>
                           </div>
                        </div>
                     </div>

                     <?php $model_num++; } ?> <!-- / End of While -->
                     
                  </tbody>
               </table>

               <div id="add_modal" class="modal fade">
                  <div class="modal-dialog" role="document">
                     <div class="modal-content">
                        <div class="modal-header">
                           <h5 class="modal-title" id="exampleModalLabel">Add New Portfolio</h5>
                           <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                           </button>
                        </div>
                        <div class="modal-body">
                           <form action="" method="post" enctype="multipart/form-data">
                              <div class="form-group">
                                 <label for="portfolio_name">Portfolio Name</label>
                                 <input type="text" class="form-control" name="portfolio_name">
                              </div>
                              <div class="form-group">
                                 <label for="portfolio_category">Portfolio Category</label>
                                 <select class="form-control" name="portfolio_category">
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
                                 <label for="portfolio_image_sm">Small Image</label>
                                 <input type="file" class="form-control" name="portfolio_image_sm">
                              </div>
                              <div class="form-group">
                                 <label for="portfolio_image_bg">Big Image</label>
                                 <input type="file" class="form-control" name="portfolio_image_bg">
                              </div>
                              <div class="form-group">
                                 <input type="submit" class="btn btn-primary" name="add_portfolio" value="Add Portfolio">
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>

               <?php
               if(isset($_GET["delete"])){
               $del_portfolio_id = $_GET["delete"];
               $sql_query = "DELETE FROM portfolios WHERE portfolio_id = {$del_portfolio_id} ";
               $del_portfolio = mysqli_query($conn, $sql_query);
               
               !$del_portfolio ? die("SQL Query Failed: " . mysqli_error($conn)) : $_SESSION['message'] = "The portfolio has been successfully deleted!";
               header("Location: portfolios.php");
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
