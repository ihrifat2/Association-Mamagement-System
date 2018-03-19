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
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarsExample07">
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
			<h1><?php echo $project_name; ?></h1>
			<p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Laboriosam, exercitationem repellendus consequatur error placeat odio alias aspernatur atque hic quibusdam consequuntur adipisci ipsam harum eligendi officiis vitae excepturi expedita culpa?.</p>
		</div>

	</main>
	<script src="asset/js/jquery-slim.min.js"></script>
    <script src="asset/js/popper.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
</body>
</html>