<aside id="aside" class="col-md-4">
         
   <div class="widget">
      <div class="widget-search">
         <form method="post" action="search.php" class="form-inline" >
            <input name="search_term" class="form-control " type="text" placeholder="Search">
            <button name="search_btn" class="btn btn-warning" type="submit"><i class="fas fa-search"></i></button>
         </form>
      </div>
   </div>
   <!-- /Search -->

   <!-- Category -->
   <div class="widget">
      <h3 class="mb-3">Categories</h3>
      <div class="widget-category">

         <?php
            $sql_query = "SELECT * FROM categories";
            $categories = mysqli_query($conn, $sql_query);

            while($category = mysqli_fetch_assoc($categories)){
               $category_name = $category["category_name"];

               $category_filter_query = "SELECT * FROM posts WHERE post_category = '$category_name'";
               $category_filtered = mysqli_query($conn, $category_filter_query);
               $category_number = mysqli_num_rows($category_filtered);

               echo "<a href='category.php?category=$category_name'>{$category_name}<span>($category_number)</span></a>";
            }
         ?>
      </div>
   </div>
   <!-- /Category -->

   <!-- Posts sidebar -->
   <div class="widget">
      <h3 class="mb-3">Latest Posts</h3>

      <!-- TODO: Automatize latest posts! -->
      <?php
         $sql = "SELECT * FROM posts LIMIT 3";
         $posts = mysqli_query($conn, $sql);
         if (!$posts) die("SQL Query Failed: " . mysqli_error($conn));

         while($post = mysqli_fetch_assoc($posts)){
            $post_id = $post['post_id'];
            $post_img = $post['post_img'];
            $post_title = $post['post_title'];
            $post_date = date('d-m-Y', strtotime($post['post_date']));

            echo "<div class='widget-post'>
                     <a href='../blog-single.php?read=$post_id'>
                        <img class='img-fluid' src='./img/$post_img' alt=''> $post_title
                     </a>
                     <ul class='blog-meta'>
                        <li>$post_date</li>
                     </ul>
                  </div>";
         }
      ?>
   </div>
   <!-- /Posts sidebar -->

</aside>