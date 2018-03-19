<?php

require 'config.php';
session_start();
if (!$_SESSION['AMS_user_login']) {
	header('Location: index.php');
	exit();
}
$username = $_SESSION['AMS_user_login'];
$userQuery = "SELECT `money`, `loan` FROM `user_data` WHERE `username` = '$username'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
if ($userData) {
	$userMoney = $userData['money'];
	$userLoan = $userData['loan'];
}
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
					if (!$_SESSION['AMS_user_login']) {
						echo '
						<li class="nav-item mr-2">
							<a class="nav-link btn btn-outline-secondary text-light" href="admin_login.php">Admin Login</a>
						</li>
						<li class="nav-item">
							<a class="nav-link btn btn-outline-secondary text-light" href="user_login.php">User Login</a>
						</li>
						';
					} else {
						echo '
						<li class="nav-item">
							<a class="nav-link btn btn-outline-secondary text-light" href="user_dashboard.php">Dashboard</a>
						</li>
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

		<div class="row AMS_userDash">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h3>Deposit Money</h3>
					</div>
					<div class="card-body">
						<?php echo $userMoney; ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h3>Loan</h3>
					</div>
					<div class="card-body ">
						<?php echo $userLoan; ?>
					</div>
				</div>
			</div>
		</div>
		<div class="row justify-content-md-center">
			<div class="col-md-6">
				<div class="card mt-4">
					<div class="card-header">
						<h3>Loan Status</h3>
					</div>
					<div class="card-body">
						<?php
							if ($userMoney >= 10000) {
								echo "You are eligible to apply for loan.";
							} else {
								echo "You are not eligible for loan.";
							}
						?>
					</div>
				</div>
			</div>
		</div>

	</main>
	<script src="asset/js/jquery-slim.min.js"></script>
    <script src="asset/js/popper.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
</body>
</html>