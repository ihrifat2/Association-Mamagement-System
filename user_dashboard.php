<?php
require 'config.php';
session_start();
if (!$_SESSION['AMS_user_login']) {
	header('Location: index.php');
	exit();
}
$username = $_SESSION['AMS_user_login'];
$userQuery = "SELECT `user_info`.`userName`, `user_info`.`userPhone`, `user_data`.`money`, `user_data`.`loan` FROM `user_info` INNER JOIN `user_data` ON `user_info`.`userUsername` = `user_data`.`username` WHERE `user_data`.`username` = '$username'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
if ($userData) {
	$userUsername		= $userData['userName'];
	$userPhone			= $userData['userPhone'];
	$userMoney			= $userData['money'];
	$userLoan			= $userData['loan'];
}
if ($userMoney > 5000) {
	$loanLimit = $userMoney * 2;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $project_name; ?></title>
	<link rel="stylesheet" href="asset/css/bootstrap.min.css">
	<link rel="stylesheet" href="asset/css/style.css">
	<style>
	
	</style>
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
							<?php echo $project_name; ?>
							<span class="sr-only">(current)</span>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="user_message.php?name=<?php echo $username ?>">Message</a>
					</li>
				</ul>
				<ul class="navbar-nav my-2 my-md-0">
					<li class="nav-item">
						<a class="nav-link btn btn-outline-secondary text-light" href="user_dashboard.php">Dashboard</a>
					</li>
					<li class="ml-2 nav-item">
						<a class="nav-link btn btn-outline-secondary text-light" href="logout.php">Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<main role="main" class="container">

		<div class="row">
			<div class="col-md-3 mt-2">
				<div class="card">
					<div class="card-header">
						<b>
							<h3>Deposit Money</h3>
						</b>
					</div>
					<div class="card-body">
						<?php echo $userMoney; ?>
					</div>
				</div>
				<div class="card mt-4">
					<div class="card-header">
						<h3>Loan</h3>
					</div>
					<div class="card-body ">
						<?php echo $userLoan; ?>
					</div>
				</div>
				<div class="card mt-4">
					<div class="card-header">
						<h3>Loan Status</h3>
					</div>
					<div class="card-body">
						<?php
							if ($userMoney >= 5000) {
								echo "You are eligible to apply for loan.";
							} else {
								echo "You are not eligible for loan.";
							}
						?>
					</div>
				</div>
				<div class="row">
					<div class="col">
						<button type="button" class="btn btn-outline-info mt-4 btn-block" data-toggle="modal" data-target="#AMSloanApply">Loan Apply</button>
					</div>
				</div>
			</div>
			<?php

				$data = array();
				$sqlquery = "SELECT `beforeWithdraw`, `withdrawMoney`, `afterWithdraw`, `time`, `date` FROM `withdraw_status` WHERE `username` = '$username' ORDER BY `withdraw_status`.`id` DESC ";
				if ($result = $conn->query($sqlquery)) {
					while ($rows = $result->fetch_array(MYSQLI_ASSOC)) {
						$data[] = $rows;
					}
					$result->close();
				}
				//$conn->close();	
			?>
			<div class="col-md-9">
				<div class="card mt-2">
					<div class="card-header">
						<h3>Withdraw Money Status</h3>
					</div>
					<div class="card-body userWithdraw">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Before Withdraw</th>
									<th>Withdraw Amount</th>
									<th>After Withdraw</th>
									<th>Date</th>
									<th>Time</th>
								</tr>
							</thead>
							<tbody>
								<?php

									foreach ($data as $row) {
										echo "<tr>";
										echo "<td>" . $row['beforeWithdraw'] . "</td>";
										echo "<td>" . $row['withdrawMoney'] . "</td>";
										echo "<td>" . $row['afterWithdraw'] . "</td>";
										echo "<td>" . $row['date'] . "</td>";
										echo "<td>" . $row['time'] . "</td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="AMSloanApply" tabindex="-1" role="dialog" aria-labelledby="AMSModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="AMSModalLabel">Apply for Loan</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<?php
						if ($userMoney <= 5000) {
							?>
							<div class="modal-body">
								<p class="text-justify">You don't have sufficient amount in your account. You have to deposit 5000 taka for loan apply.</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
							</div>
							<?php
						} elseif ($userLoan != 0) {
							?>
							<div class="modal-body">
								<p class="text-justify">Your last loan repayment isn't complete yet. Please pay off all of your loan money afterwards you can apply for new loan</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
							</div>
							<?php
						} else {
							?>
							<form action="#" method="post">
								<div class="modal-body">
									<div class="form-group row">
		                            	<label for="Name" class="col-sm-3 col-form-label">Full Name</label>
		    							<div class="col-sm-9">
			                                <input type="text" name="loanName" id="name" tabindex="1" class="form-control" maxlength="45" value="<?php echo $userUsername ?>">
			                            </div>
		                            </div>
		                            <div class="form-group row">
		                            	<label for="NID" class="col-sm-3 col-form-label">National ID</label>
		    							<div class="col-sm-9">
		                                	<input type="text" name="loanNid" id="nid" tabindex="1" class="form-control" maxlength="95">
		                                </div>
		                            </div>
		                            <div class="form-group row">
		                            	<label for="Phone" class="col-sm-3 col-form-label">Phone</label>
		    							<div class="col-sm-9">
		                                	<input type="text" name="loanPhn" id="phone" tabindex="1" class="form-control" maxlength="20" value="<?php echo $userPhone ?>">
		                                </div>
		                            </div>
		                            <div class="form-group row">
		                            	<label for="Address" class="col-sm-3 col-form-label">Address</label>
		    							<div class="col-sm-9">
		                                	<input type="text" name="loanAddress" id="Address" tabindex="2" class="form-control" maxlength="30">
		                                </div>
		                            </div>
		                            <div class="form-group row">
		                            	<label for="Amount" class="col-sm-3 col-form-label">Amount</label>
		    							<div class="col-sm-9">
		                                	<input type="text" name="loanAmount" id="Amount" tabindex="2" class="form-control" maxlength="10" value="<?php echo $loanLimit ?>">
		                                </div>
		                            </div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
									<button type="submit" class="btn btn-danger" name="loanApply">Submit</button>
								</div>
							</form>
							<?php
						}
					?>
				</div>
			</div>
		</div>

		<!-- <button onclick="amsFlashMessage()">Show Snackbar</button> -->
		
	</main>
	<script src="asset/js/jquery-slim.min.js"></script>
    <script src="asset/js/popper.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
	<script>
	function amsFlashMessage() {
	    var x = document.getElementById("snackbar")
	    x.className = "show";
	    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
	}
	</script>
</body>
</html>
<?php
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if (isset($_POST['loanApply'])) {
	$name 			= validate_input($_POST['loanName']);
	$nid 			= validate_input($_POST['loanNid']);
	$phone 			= validate_input($_POST['loanPhn']);
	$address 		= validate_input($_POST['loanAddress']);
	$amount 		= validate_input($_POST['loanAmount']);
	//echo $name . " : " . $nid . " : " . $phone . " : " . $address . " : " . $amount;
	if (!empty($name) || !empty($nid) || !empty($phone) || !empty($address) || !empty($amount)) {
		$loanQuery = "INSERT INTO `loan_apply`(`id`, `username`, `name`, `nid`, `phone`, `address`, `amount` , `loanLimit`) VALUES (NULL,'$username','$name','$nid','$phone','$address','$amount', '$loanLimit')";
		$loanResult = mysqli_query($conn, $loanQuery);
		if ($loanResult) {
			echo '<div id="snackbar">Loan apply successful..</div>';
			echo "<script>amsFlashMessage()</script>";
		}
	} else {
		echo '<div id="snackbar">All fields are required.</div>';
		echo "<script>amsFlashMessage()</script>";
	}
}
?>