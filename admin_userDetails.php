<?php
//require config file(db connection)
require 'config.php';
session_start();
//check Authentication and name
if (!$_SESSION['AMS_admin_login'] || isset($_GET['name']) == '') {
	header('Location: index.php');
	exit();
}
$name = mysqli_real_escape_string($conn, $_GET['name']);
if (isset($_GET)) {
    $sqlQuery = "SELECT `money` FROM `user_data` WHERE `username` = '$name'";
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
	
	<main role="main" class="container-fluid">
		<div class="row">
			<div class="col-md-6 mt-2">
				<div class="card">
					<div class="card-header bg-success">
						<h3>Deposit</h3>
					</div>
					<div class="card-body">
						<table class="table table-hover table-sm table-bordered table-striped">
							<thead>
								<tr>
									<th scope="col">Deposit</th>
									<th scope="col">Total</th>
									<th scope="col">Date</th>
									<th scope="col">Week</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$depoData = array();
									$depoSqlQuery = "SELECT `depositMoney`, `totalMoney`, `date` FROM `ams_deposit` WHERE `username` = '$name' ORDER by `id` ASC";
									if ($depoResult = $conn->query($depoSqlQuery)) {
										while ($depoRows = $depoResult->fetch_array(MYSQLI_ASSOC)) {
											$depoData[] = $depoRows;
										}
										$depoResult->close();
									}
									//$conn->close();
									$week = 1;
									foreach ($depoData as $depoRow) {
										echo "<tr>";
										echo "<td>" . $depoRow['depositMoney'] . "</td>";
										echo "<td>" . $depoRow['totalMoney'] . "</td>";
										echo "<td>" . $depoRow['date'] . "</td>";
										echo "<td>" . $week . "</td>";
										echo "</tr>";
										$week++;
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-md-6 mt-2">
				<div class="card">
					<div class="card-header bg-info">
						<h3>Withdraw</h3>
					</div>
					<div class="card-body">
						<table class="table table-hover table-sm table-bordered table-striped">
							<thead>
								<tr>
									<th scope="col">Withdraw Money</th>
									<th scope="col">Money Left</th>
									<th scope="col">Date</th>
									<th scope="col">time</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$withdrawData = array();
									$withdrawSqlQuery = "SELECT `withdrawMoney`, `afterWithdraw`, `time`, `date` FROM `withdraw_status` WHERE `username` = '$name' ORDER by `id` ASC";
									if ($withdrawResult = $conn->query($withdrawSqlQuery)) {
										while ($withdrawRows = $withdrawResult->fetch_array(MYSQLI_ASSOC)) {
											$withdrawData[] = $withdrawRows;
										}
										$withdrawResult->close();
									}
									//$conn->close();
									foreach ($withdrawData as $withdrawRow) {
										echo "<tr>";
										echo "<td>" . $withdrawRow['withdrawMoney'] . "</td>";
										echo "<td>" . $withdrawRow['afterWithdraw'] . "</td>";
										echo "<td>" . $withdrawRow['date'] . "</td>";
										echo "<td>" . $withdrawRow['time'] . "</td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</main>
    <script src="asset/js/jquery-slim.min.js"></script>
    <script src="asset/js/popper.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
	<script>
		/*snackbar flash message*/
		function amsFlashMessage() {
		    var x = document.getElementById("snackbar")
		    x.className = "show";
		    setTimeout(function(){
		    	x.className = x.className.replace("show", "");
		    }, 3000);
		}
	</script>
</body>
</html>