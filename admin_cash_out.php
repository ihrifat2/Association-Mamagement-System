<?php

require 'config.php';
session_start();
if (!$_SESSION['AMS_admin_login'] || isset($_GET['id']) == '') {
	header('Location: index.php');
	exit();
}
if (isset($_GET)) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sqlQuery = "SELECT `username`, `money` FROM `user_data` WHERE `id` = '$id'";
    $result= mysqli_query($conn, $sqlQuery);
    $rows = mysqli_fetch_assoc($result);
    if ($rows) {
        $userMoney = $rows['money'];
        $userUsername = $rows['username'];
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
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#AMSNavbar" aria-controls="AMSNavbar" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="AMSNavbar">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="index.php">
							<i class="fas fa-home"></i>
							HOME
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="admin_loan.php">
							Loan Request
						</a>
					</li>
				</ul>
				<ul class="navbar-nav my-2 my-md-0">
					<li class="nav-item">
						<a class="nav-link btn btn-outline-secondary text-light" href="admin_dashboard.php">Dashboard</a>
					</li>
					<li class="ml-2 nav-item">
						<a class="nav-link btn btn-outline-secondary text-light" href="logout.php">Logout</a>
					</li>
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
									<input type="text" readonly class="form-control-plaintext" id="currentStatus" value="<?php echo $userMoney ?>">
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
	<script>
	function amsFlashMessage() {
	    var x = document.getElementById("snackbar")
	    x.className = "show";
	    setTimeout(function(){
	    	x.className = x.className.replace("show", "");
	    	document.location='admin_dashboard.php';
	    }, 3000);
	}
	</script>
</body>
</html>
<?php
if (isset($_POST['withdrawSub'])) {
	$withdrawMoney = $_POST['withdraw'];
	$withdrawMoney2 = $_POST['withdraw'];
	$date = date('Y-m-d');
	$t = date('H');
	$t = $t + 4;
	$time = $t . date(':i:s');
	if ($withdrawMoney <= ($userMoney-500)) {
		$withdrawMoney = $userMoney - $withdrawMoney;
		$withdrawQuery1 = "UPDATE `user_data` SET `money`='$withdrawMoney' WHERE `id` = '$id'";
		$withdrawQuery2 = "INSERT INTO `withdraw_status`(`id`, `username`, `beforeWithdraw`, `withdrawMoney`, `afterWithdraw`, `time`, `date`) VALUES (NULL,'$userUsername','$userMoney','$withdrawMoney2','$withdrawMoney','$time','$date')";
		$withdrawResult1 = mysqli_query($conn, $withdrawQuery1);
		$withdrawResult2 = mysqli_query($conn, $withdrawQuery2);
		if ($withdrawResult1 && $withdrawResult2) {
			echo '<div id="snackbar">Withdraw Successful.</div>';
			echo "<script>amsFlashMessage()</script>";
			// echo "<script>javascript:document.location='admin_dashboard.php'</script>";
			
	    }else{
	        echo '<script>document.getElementById("error").innerHTML="Failed to Withdraw."</script>';
		}
	} else {
		echo '<script>document.getElementById("error").innerHTML="Insufficient Balance."</script>';
	}
}
?>