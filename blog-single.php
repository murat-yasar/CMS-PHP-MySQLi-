<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<?php
	if(isset($_GET['read'])){
		$post_id = $_GET['read'];
		$hit_query = "UPDATE posts SET post_hits = post_hits + 1 WHERE post_id = $post_id";
		$hit_count = mysqli_query($conn, $hit_query);
	}

	$posts_query = "SELECT * FROM posts WHERE post_id = $post_id";
	$posts = mysqli_query($conn, $posts_query);

	$comments_query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} AND comment_status = 'approved' ORDER BY comment_id DESC";
	$comments = mysqli_query($conn, $comments_query);
	$comments_count = mysqli_num_rows($comments);
	
	while($post = mysqli_fetch_assoc($posts)){
		$post_title = $post["post_title"];
		$post_author = $post["post_author"];
		$post_date = $post["post_date"];
		$post_img = $post["post_img"];
		$post_text = $post["post_text"];
		$post_tags = $post["post_tags"];
		$post_hits = $post["post_hits"];
?>

<?php
	if(isset($_POST['create_comment'])){
		$comment_author = $_POST['comment_author'];
		$comment_email = $_POST['comment_email'];
		$comment_text = $_POST['comment_text'];

		$post_id = $_GET['read'];

		$sql_query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_text, comment_status,  comment_date) VALUES ($post_id, '{$comment_author}', '{$comment_email}', '{$comment_text}', 'unapproved', now())";
		$comment_query = mysqli_query($conn, $sql_query);

		$_SESSION['message'] = "Your comment has been successfully sent!";
		header("Location: blog-single.php?read={$post_id}");
		exit();
	}
?>

	<!--==========================
    INSIDE HERO SECTION Section
	============================-->
	<section class="page-image page-image-contact md-padding">
		<h1 class="text-white text-center">BLOG</h1>
	</section>

	<!--==========================
    Contact Section
	============================-->
	<section id="blog" class="md-padding">
		<div class="container">
			<div class="row">
				<main id="main" class="col-md-8">
					<div class="blog">
						<div class="blog-img">
							<img class="img-fluid" src="./img/<?php echo $post_img; ?>" alt="">
						</div>
						<div class="blog-content">
							<ul class="blog-meta">
								<li><i class="fas fa-user"></i><?php echo $post_author; ?></li>
								<li><i class="fas fa-clock"></i><?php echo $post_date; ?></li>
								<li><i class="fas fa-comments"></i><?php echo $comments_count; ?></li>
								<li><i class="fas fa-eye"></i><?php echo $post_hits; ?></li>
								<li><i class="fas fa-tag"></i><?php echo $post_tags; ?></li>
							</ul>
							<h3><?php echo $post_title; ?></h3>
							<p><?php echo $post_text; ?></p>
						</div>

						<!-- blog comments -->
						<div class="blog-comments">							
							<?php 
								$comments_query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} AND comment_status = 'approved' ORDER BY comment_id DESC";
								$comments = mysqli_query($conn, $comments_query);
								// $comments_count = mysqli_num_rows($comments);

								echo "<h3>({$comments_count}) Comments</h3>";

								while($comment = mysqli_fetch_assoc($comments)){
									$comment_author = $comment["comment_author"];
									$comment_text = $comment["comment_text"];
									$comment_date = date('d-m-Y', strtotime($comment['comment_date']));

									echo "
										<div class='media'>
											<div class='media-body'>
												<h4 class='media-heading'>{$comment_author}<span class='time'>{$comment_date}</span></h4>
												<p>{$comment_text}</p>
											</div>
										</div>
									";
								}
							?>
						</div>
						<!-- /blog comments -->

						<!-- reply form -->
						<div class="reply-form">
							<h3>Leave A Comment</h3>
							<form action="" method="post">
								<input class="form-control mb-4" type="text" name="comment_author" placeholder="Name">
								<input class="form-control mb-4" type="email" name="comment_email" placeholder="Email">
								<textarea class="form-control mb-4" row="5" name="comment_text" placeholder="Add Your Commment"></textarea>
                                
								<button type="submit" class="main-btn" name="create_comment">Submit</button>
							</form>
						</div>
						<!-- /reply form -->
					</div>
				
					<?php	} ?>
					<!-- /Blog -->

				</main>
				<!-- /Main -->
				
				<!-- Sidebar -->
				<?php include "includes/sidebar.php"; ?>
				
			</div>
		</div>
	</section>

<!-- Footer -->
<?php include "includes/footer.php"; ?>