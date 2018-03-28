<?php

require 'config.php';
session_start();
if (!$_SESSION['AMS_admin_login'] || isset($_GET['id']) == '') {
	header('Location: index.php');
	exit();
}
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
							Loan
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
						<h3>Deposit money</h3>
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
								<label for="deposit" class="col-sm-4 col-form-label">Enter Amount</label>
								<div class="col-sm-8">
									<input type="number" class="form-control" id="deposit" name="deposit">
								</div>
							</div>
							<p id="error" class="error"></p>
							<p id="success" class="success"></p>
							<button type="submit" class="btn btn-info float-right" name="depositSub">Submit</button>
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
if (isset($_POST['depositSub'])) {
	$depoMoney = $_POST['deposit'];
	$depoMoney += $userMoney;
	$depoQuery = "UPDATE `user_data` SET `money`='$depoMoney' WHERE `id` = '$id'";
	$depoResult = mysqli_query($conn, $depoQuery);
	if ($depoResult) {
		echo '<div id="snackbar">Deposit Successful.</div>';
		echo "<script>amsFlashMessage()</script>";
		// echo "<script>javascript:document.location='admin_dashboard.php'</script>";
    }else{
        echo '<script>document.getElementById("error").innerHTML="Failed to Deposit."</script>';
	}
}
?>