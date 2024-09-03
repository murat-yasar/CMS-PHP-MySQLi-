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
                     <th>Portfolio Name</th>
                     <th>Portfolio Category</th>
                     <th>Image (SM)</th>
                     <th>Image (BG)</th>
                     <th>Add/Edit/Delete</th>
                  </tr>
               </thead>

               <tbody>
                  <?php
                     $sql_query = "SELECT * FROM portfolios ORDER BY portfolio_id DESC";
                     $portfolios = mysqli_query($conn, $sql_query);

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
                                       <a class='dropdown-item' href='#' data-toggle='modal' data-target='#add_modal'>Add</a>
                                       <div class='dropdown-divider'></div>
                                       <a class='dropdown-item' href='#' data-toggle='modal' data-target='#edit_modal$model_num'>Edit</a>
                                       <div class='dropdown-divider'></div>
                                       <a class='dropdown-item' href='categories.php?delete={$portfolio_id}'>Delete</a>
                                       </div>
                                    </div>
                                 </td>
                              </tr>";
                  ?>

                  <div id="edit_modal" class="modal fade">
                     <div class="modal-dialog" role="document">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Edit Portfolio</h5>
                              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <form action="" method="post">
                                 <div class="form-group">
                                    <label for="portfolio_name">Portfolio Name</label>
                                    <input type="text" class="form-control" name="portfolio_name" value="">
                                 </div>
                                 <div class="form-group">
                                    <label for="portfolio_category">Portfolio Category</label>
                                    <input type="text" class="form-control" name="portfolio_category" value="">
                                 </div>
                                 <div class="form-group">
                                    <label for="portfolio_image_sm">Small Image</label>
                                    <input type="file" class="form-control" name="portfolio_image_sm" value="">
                                 </div>
                                 <div class="form-group">
                                    <label for="portfolio_image_bg">Big Image</label>
                                    <input type="file" class="form-control" name="portfolio_image_bg" value="">
                                 </div>
                                 <div class="form-group">
                                    <input type="hidden" name="portfolio_id" value="">
                                    <input type="submit" class="btn btn-primary" name="edit_portfolio"
                                       value="Edit Portfolio">
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>

                  <?php } ?> <!-- / End of While -->
                  
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
                        <form action="" method="post">
                           <div class="form-group">
                              <label for="portfolio_name">Portfolio Name</label>
                              <input type="text" class="form-control" name="portfolio_name">
                           </div>
                           <div class="form-group">
                              <label for="portfolio_category">Portfolio Category</label>
                              <input type="text" class="form-control" name="portfolio_category">
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

         </div> <!-- /.container-fluid -->

         <!-- Footer -->
         <?php include "includes/admin_footer.php"; ?>

      </div> <!-- /.content-wrapper -->
   </div><!-- /#wrapper -->

   <!-- Scripts -->
   <?php include "includes/admin_scripts.php"; ?>
</body>
</html>