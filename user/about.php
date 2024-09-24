<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>


	<!--==========================
    INSIDE HERO SECTION Section
	============================-->
	<section class="page-image page-image-about md-padding">
		<h1 class="text-white text-center">ABOUT</h1>
	</section>

	<!--==========================
    ABOUTUS Section
	============================-->
	<section id="aboutus" class="md-padding">
		<div class="container">

			<div class="row text-center">
				<div class="col-md-4 offset-md-4">
					<div class="section-header">
						<h2 class="title">How We Begin</h2>
					</div>
				</div>
			</div>
			<div class="row justify-content-center no-gutters mb-5 mb-lg-0">
				<div class="col-md-6">
					<img class="img-fluid" src="img/company.jpg" alt="">
				</div>
				<div class="col-md-6">
					<div class="bg-main text-center h-100 project">
						<div class="d-flex h-100">
							<div class="project-text w-100 my-auto text-center text-lg-left">
								<p class="mb-3 text-white">An example of where you can put an image of a project, or anything else, along with a description.An example of where you can put an image of a project, or anything else, along with a description.
									<br>
									<br>An example of where you can put an image of a project, or anything else, along with a description.An example of where you can put an image of a project, or anything else, along with a description.</p>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!--==========================
    THE TEAM
	============================-->

	<section id="team" class="md-padding">
		<div class="container">

			<div class="row text-center">
				<div class="col-md-4 offset-md-4">
					<div class="section-header">
						<h2 class="title">The Team</h2>
					</div>
				</div>
			</div>

			<!-- TODO: Fetch the employees from the DB -->
			<div class="row">
				<?php
					$sql = "SELECT * FROM employees";
					$employees = mysqli_query($conn, $sql);
					if(!$employees) die("SQL Query Failed: " . mysqli_error($conn));

					while($employee = mysqli_fetch_assoc($employees)){
						$employee_name = $employee['employee_name'];
						$employee_title = $employee['employee_title'];
						$employee_img = $employee['employee_img'];
						$employee_x = $employee['employee_x'];
						$employee_facebook = $employee['employee_facebook'];
						$employee_linkedin = $employee['employee_linkedin'];

						echo "<div class='col-md-4'>
									<div class='team-member'>
										<img class='mx-auto rounded-circle' src='img/{$employee_img}' alt=''>
										<h4>$employee_name</h4>
										<p class='text-muted'>$employee_title</p>
										<ul class='list-inline social-buttons'>
											<li class='list-inline-item'>
												<a href='{$employee_x}'>
													<i class='fab fa-twitter'></i>
												</a>
											</li>
											<li class='list-inline-item'>
												<a href='{$employee_facebook}'>
													<i class='fab fa-facebook-f'></i>
												</a>
											</li>
											<li class='list-inline-item'>
												<a href='{$employee_linkedin}'>
													<i class='fab fa-linkedin-in'></i>
												</a>
											</li>
										</ul>
									</div>
								</div>";
					}
				?>
			</div>
		</div>
	</section>

<!-- Footer -->
<?php include "includes/footer.php"; ?>