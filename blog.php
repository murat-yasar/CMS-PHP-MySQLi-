<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>


	<!--==========================
    INSIDE HERO SECTION Section
	============================-->
	<section class="page-image page-image-blog md-padding">
		<h1 class="text-white text-center">BLOG</h1>
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
							$sql_query = "SELECT * FROM posts";
							$posts = mysqli_query($conn, $sql_query);
							
							while($post = mysqli_fetch_assoc($posts)){
								$post_title = ucfirst($post["post_title"]);   // ucfirst(); Capitilizes the first letters of each word
								$post_author = $post["post_author"];
								$post_date = $post["post_date"];
								$post_comment_number = $post["post_comment_number"];
								$post_image_url = $post["post_image_url"];
								$post_text = substr($post["post_text"], 0, 100);   // substr($text, i, n); Takes the n number of characters starting from position i
								$post_tags = $post["post_tags"];
						?>

						<!-- Blog-Post -->
						<div class="col-md-6">
							<div class="blog">
								<div class="blog-img">
									<img src=<?php echo "img/$post_image_url"; ?> class="img-fluid">
								</div>
								<div class="blog-content">
									<ul class="blog-meta">
										<li><i class="fas fa-users"></i><span class="writer"><?php echo $post_author; ?></span></li>
										<li><i class="fas fa-clock"></i><span class="writer"><?php echo $post_date; ?></span></li>
										<li><i class="fas fa-comments"></i><span class="writer"><?php echo $post_comment_number; ?></span></li>
									</ul>
									<h3><?php echo $post_title; ?></h3>
									<p><?php echo $post_text; ?></p>
									<a href="blog-single.php">Read More</a>
								</div>
							</div>
						</div>

						<!-- Blog-Post END -->
						<?php	} ?>

					</div>

					<!-- Pagination -->
					<div class="row">
						<div class="col-md-6">
							<nav aria-label="Page navigation example">
								<ul class="pagination justify-content-center">
									<li class="page-item disabled">
										<a class="page-link" href="#" tabindex="-1">Previous</a>
									</li>
									<li class="page-item"><a class="page-link" href="#">1</a></li>
									<li class="page-item"><a class="page-link" href="#">2</a></li>
									<li class="page-item"><a class="page-link" href="#">3</a></li>
									<li class="page-item">
										<a class="page-link" href="#">Next</a>
									</li>
								</ul>
							</nav>
						</div>
					</div>
				</main>
				
				<!-- Sidebar -->
				<?php include "includes/sidebar.php"; ?>
				
			</div>
		</div>
	</section>

<!-- Footer -->
<?php include "includes/footer.php"; ?>