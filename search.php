<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>


	<!--==========================
    INSIDE HERO SECTION Section
	============================-->
	<section class="page-image page-image-blog md-padding">
		<h1 class="text-white text-center">MY/BLOG</h1>
	</section>

	<!--==========================
    Contact Section
	============================-->
	<section id="blog" class="md-padding">
		<div class="container">
			<div class="row">
				<main id="main" class="col-md-8">

					<div class="row">
						<?php
							if(isset($_POST['search_btn'])){
								$term = $_POST['search_term'];
			
								$query = "SELECT * FROM posts WHERE post_tags LIKE '%$term%' OR post_author LIKE '%$term%' ORDER BY post_id DESC";
								$results = mysqli_query($conn, $query);
			
								if(!$results){
									die("SQL FAILED: ". mysqli_error($conn));
								}
			
								$search_count =  mysqli_num_rows($results);
			
								if($search_count == 0) {
									echo "<h3 class='text-danger'>There is no result for the searched term: '$term'</h3>";
								} else 
								{
									while($post = mysqli_fetch_assoc($results)){
										$post_id = $post["post_id"];
										$post_title = ucfirst($post["post_title"]);
										$post_author = $post["post_author"];
										$post_date = $post["post_date"];
										$post_img = $post["post_img"];
										$post_text = substr($post["post_text"], 0, 100);
										$post_tags = $post["post_tags"];
										$post_hits = $post["post_hits"];

										echo "<div class='col-md-6'>
													<div class='blog'>
														<div class='blog-img'>
															<img src='img/$post_img' class='img-fluid'>
														</div>
														<div class='blog-content'>
															<ul class='blog-meta'>
																<li><i class='fas fa-users'></i><span class='writer'>$post_author</span></li>
																<li><i class='fas fa-clock'></i><span lass='writer'>$post_date</span></li>
																<li><i class='fas fa-eye'></i><span lass='writer'>$post_hits</span></li>
															</ul>
															<h3>$post_title</h3>
															<p>$post_text</p>
															<a href='blog-single.php?read=$post_id'>Read More</a>
														</div>
													</div>
												</div>";
									}	
								}
							}			
						?>
						<!-- Blog-Post END -->

					</div>
				</main>
				
				<!-- Sidebar -->
				<?php include "includes/sidebar.php"; ?>
				
			</div>
		</div>
	</section>

<!-- Footer -->
<?php include "includes/footer.php"; ?>