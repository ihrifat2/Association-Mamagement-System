<?php

require 'config.php';
session_start();
if (!$_SESSION['AMS_admin_login'] || isset($_GET['id']) == '') {
	header('Location: index.php');
	exit();
}
$username = $_SESSION['AMS_admin_login'];
if (isset($_GET)) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sqlQuery = "SELECT `money` FROM `user_data` WHERE `id` = '$id'";
    $result= mysqli_query($conn, $sqlQuery);
    $rows = mysqli_fetch_assoc($result);
    if ($rows) {
        $userMoney = $rows['money'];
    }
}
if(isset($userMoney) == NULL){
    header('location: error.php');
}

?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $project_name; ?></title>
	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	<link rel="stylesheet" href="asset/css/style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css">
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
					if (!$_SESSION['AMS_admin_login']) {
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
							<a class="nav-link btn btn-outline-secondary text-light" href="admin_dashboard.php">Dashboard</a>
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
	<div class="container">
		<div class="row justify-content-md-center">
			<div class="col-md-6">
				<div class="card mt-4">
					<div class="card-header">
						<h3>Withdraw Money</h3>
					</div>
					<div class="card-body ">
						<form method="post" action="">
							<div class="form-group row">
								<label for="currentStatus" class="col-sm-4 col-form-label">Current Amount</label>
								<div class="col-sm-8">
									<input type="number" readonly class="form-control-plaintext" id="currentStatus" value="<?php echo $userMoney ?>">
								</div>
							</div>
							<div class="form-group row">
								<label for="withdraw" class="col-sm-4 col-form-label">Enter Amount</label>
								<div class="col-sm-8">
									<input type="number" class="form-control" id="withdraw" name="withdraw">
								</div>
							</div>
							<p id="error" class="error"></p>
							<p id="success" class="success"></p>
							<button type="submit" class="btn btn-info float-right" name="withdrawSub">Submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="asset/js/jquery-slim.min.js"></script>
    <script src="asset/js/popper.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
</body>
</html>
<?php
if (isset($_POST['withdrawSub'])) {
	$withdrawMoney = $_POST['withdraw'];
	if ($withdrawMoney <= ($userMoney-500)) {
		$withdrawMoney = $userMoney - $withdrawMoney;
		$withdrawQuery = "UPDATE `user_data` SET `money`='$withdrawMoney' WHERE `id` = '$id'";
		$withdrawResult = mysqli_query($conn, $withdrawQuery);
		if ($withdrawResult) {
			echo '<script>document.getElementById("success").innerHTML="Withdraw Successful."</script>';
	    }else{
	        echo '<script>document.getElementById("error").innerHTML="Failed to Withdraw."</script>';
		}
	} else {
		echo '<script>document.getElementById("error").innerHTML="Insufficient Balance."</script>';
	}
}
?>