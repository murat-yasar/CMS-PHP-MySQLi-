<?php include "includes/db.php"; ?>

<!-- Header -->
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>


<!--==========================
    INSIDE HERO SECTION Section
============================-->	
<section class="page-image page-image-portfolio md-padding">
    <h1 class="text-white text-center">PORTFOLIO</h1>
</section>
    
<!--==========================
    PORTFOLIO Section
============================-->
<section id="portfolio" class="md-padding">
    <div class="container">

			<div class="row text-center">
				<div class="col-md-4 offset-md-4">
					<div class="section-header">
						<h2 class="title">Our Works</h2>
					</div>
				</div>
			</div>
        <div class="row">
            <?php
                $sql_query = "SELECT * FROM portfolios";
                $portfolios = mysqli_query($conn, $sql_query);

                while($portfolio = mysqli_fetch_assoc($portfolios)){
                    $portfolioId = $portfolio['portfolio_id'];
                    $portfolioName = $portfolio['portfolio_name'];
                    $portfolioCategory = $portfolio['portfolio_category'];
                    $portfolioImgSm = $portfolio['portfolio_img_sm'];
                    $portfolioImgBg = $portfolio['portfolio_img_bg'];
            ?>

            <div class='col-md-4 col-sm-6 portfolio-item'>
                <a href="img/<?php echo $portfolioImgSm; ?>" class="portfolio-link" data-lightbox="<?php echo $portfolioCategory; ?>" data-title="<?php echo $portfolioName; ?>" >
                    <div class="portfolio-hover">
                        <div class="portfolio-hover-content">
                            <i class="fas fa-search fa-3x"></i>
                        </div>
                    </div>
                    <img class="img-fluid" src="img/<?php echo $portfolioImgBg; ?>" alt="">
                </a>
                <div class="portfolio-caption">
                    <h4><?php echo $portfolioName; ?></h4>
                    <p class="text-muted"><?php echo $portfolioCategory; ?></p>
                </div>
            </div>

            <?php } ?>
        </div>
    </div>
</section>

<!-- Footer -->
<?php include "includes/footer.php"; ?>