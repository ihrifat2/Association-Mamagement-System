<?php

require 'config.php';
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $project_name; ?></title>
	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	<link rel="stylesheet" href="asset/css/style.css">
</head>
<body class="text-center">

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#AMSNavbar" aria-controls="AMSNavbar" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="AMSNavbar">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="index.php"><?php echo $project_name; ?> <span class="sr-only">(current)</span></a>
					</li>
				</ul>
				<ul class="navbar-nav my-2 my-md-0">
					<?php
					if (!$_SESSION) {
						echo '
						<li class="nav-item mr-2">
							<a class="nav-link btn btn-outline-secondary text-light" href="admin_login.php">Admin Login</a>
						</li>
						<li class="nav-item">
							<a class="nav-link btn btn-outline-secondary text-light" href="user_login.php">User Login</a>
						</li>
						';
					} else {
						if ($_SESSION['AMS_admin_login']) {
							echo '
							<li class="nav-item">
								<a class="nav-link btn btn-outline-secondary text-light" href="admin_dashboard.php">Dashboard</a>
							</li>
							';
						} else {
							echo '
							<li class="nav-item">
								<a class="nav-link btn btn-outline-secondary text-light" href="user_dashboard.php">Dashboard</a>
							</li>
							';
						}
						echo '
						<li class="ml-2 nav-item">
							<a class="nav-link btn btn-outline-secondary text-light" href="logout.php">Logout</a>
						</li>
						';
					}
					?>
				</ul>
			</div>
		</div>
	</nav>

	<main role="main" class="container">

		<div class="starter-template">
			<!-- <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam, exercitationem repellendus consequatur error placeat odio alias aspernatur atque hic quibusdam consequuntur adipisci ipsam harum eligendi officiis vitae excepturi expedita culpa?</p> -->
		</div>
		<div class="row justify-content-md-center">
			<div class="col-md-9">
				<div id="carouselExampleIndicators" class="carousel slide mt-2" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
						<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
					</ol>
					<div class="carousel-inner">
						<div class="carousel-item active">
							<img class="d-block w-100" src="asset/img/1stSlide.PNG" alt="First slide">
							<div class="carousel-caption">
								<?php echo $project_name; ?>
							</div>
						</div>
						<div class="carousel-item">
							<img class="d-block w-100" src="asset/img/2ndSlide.PNG" alt="Second slide">
							<div class="carousel-caption">
								<?php echo $project_name; ?>
							</div>
						</div>
						<div class="carousel-item">
							<img class="d-block w-100" src="asset/img/3rdSlide.PNG" alt="Third slide">
							<div class="carousel-caption">
								<?php echo $project_name; ?>
							</div>
						</div>
					</div>
					<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>	
		</div>
		<footer class="my-5 pt-5 text-muted text-center text-small">
			<p class="mb-1">© 2018 <?php echo $project_name; ?></p>
			<ul class="list-inline">
				<li class="list-inline-item"><a href="#">Privacy</a></li>
				<li class="list-inline-item"><a href="#">Terms</a></li>
				<li class="list-inline-item"><a href="#">Support</a></li>
			</ul>
		</footer>
	</main>
	<script src="asset/js/jquery-slim.min.js"></script>
    <script src="asset/js/popper.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
</body>
</html>
<!-- https://bootsnipp.com/snippets/35k9B -->