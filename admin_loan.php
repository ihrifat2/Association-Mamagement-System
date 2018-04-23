<?php
//require config file(db connection)
require 'config.php';
session_start();
//check Admin Authentication
if (!$_SESSION['AMS_admin_login']) {
	header('Location: index.php');
	exit();
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
	<?php
		$amsDataLA = array();
		$amsSqlQueryLA = "SELECT `id`, `username`, `name`, `nid`, `phone`, `address`, `amount`, `loanLimit` FROM `loan_apply` WHERE `loanGiven` = 0";
		if ($amsResultLA = $conn->query($amsSqlQueryLA)) {
			while ($rowsLA = $amsResultLA->fetch_array(MYSQLI_ASSOC)) {
				$amsDataLA[] = $rowsLA;
			}
			$amsResultLA->close();
		}
		//$conn->close();
	?>
	<main role="main" class="container">
		<div class="row justify-content-md-center">
			<div class="col-sm-10 mt-4">
				<div class="card">
					<div class="card-header">
						<h2>Request list for Loan</h2>
					</div>
					<div class="card-body">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Full Name</th>
									<th>NID</th>
									<th>Phone</th>
									<th>Address</th>
									<th>Amount</th>
									<th>Loan Limit</th>
									<th>Approval</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach ($amsDataLA as $rowLA) {
										echo "<tr>";
										echo "<td>" . ucfirst($rowLA['name']) . "</td>";
										echo "<td>" . $rowLA['nid'] . "</td>";
										echo "<td>" . $rowLA['phone'] . "</td>";
										echo "<td>" . $rowLA['address'] . "</td>";
										echo "<td>" . $rowLA['amount'] . "</td>";
										echo "<td>" . $rowLA['loanLimit'] . "</td>";
										echo '<td><button type="button" class="btn btn-info" onclick="loanAmountId(\''.$rowLA['username'].'\', '.$rowLA['id'].')" data-toggle="modal" data-target="#AMSWithdrawRequest">Action</button></td>';
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
		<div class="modal fade" id="AMSWithdrawRequest" tabindex="-1" role="dialog" aria-labelledby="AMSModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="AMSModalLabel">Loan Approval</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="#" method="post">
						<div class="modal-body">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" for="amsLoanApproval">Eligible for loan?</label>
								</div>
								<select class="custom-select" id="amsLoanApproval" name="loanOption" onclick="loanoption()">
									<option value="0">Yes</option>
									<option value="1">No</option>
								</select>
							</div>
                            <div class="form-group row" id="amsloanAmmount">
                            	<label for="Amount" class="col-sm-2 col-form-label">Amount</label>
    							<div class="col-sm-10">
    								<input type="text" name="RequestLoanAmount" id="LoanAmount" tabindex="2" class="form-control" maxlength="10">
    							</div>
                            </div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-danger" id="RequestLoanbtn" name="RequestLoan">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>

	</main>
    <script src="asset/js/jquery-slim.min.js"></script>
    <script src="asset/js/popper.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
	<script>
		//Loan request button hide/show
		function loanoption() {
			var x = document.getElementById('amsLoanApproval').value;
			if (x == 1) {
				document.getElementById('amsloanAmmount').style.display='none'
				document.getElementById('RequestLoanbtn').style.display='none'
			}
			if (x == 0) {
				document.getElementById('amsloanAmmount').removeAttribute("style");
				document.getElementById('RequestLoanbtn').removeAttribute("style");
			}
		}
		// Create cookie to grab username and id for loan process
		function loanAmountId(uname, id){
			// var idd = id;
			// var usname = uname;
    		document.cookie="requestLoanUserId="+id;
    		document.cookie="requestLoanUserUname="+uname;
    	}
    	/*snackbar for flash message*/
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
<?php
function interestCount($loanMoney)
{
    $interestMoney = ($loanMoney * 20) / 100;
    return $interestMoney;
}
if (isset($_POST['RequestLoan'])) {
	$requestLoanUserId = $_COOKIE['requestLoanUserId'];
	$requestLoanUserUname = $_COOKIE['requestLoanUserUname'];
	$LoanApprovalMoney = $_POST['RequestLoanAmount'];
	$loanInterest = interestCount($LoanApprovalMoney);
	$loanTotal = $LoanApprovalMoney + $loanInterest;
	if (!empty($LoanApprovalMoney)) {
		$LoanApprovalQuary = "UPDATE `loan_apply` SET `loanGiven` = '$LoanApprovalMoney' WHERE `id` = '$requestLoanUserId'";
		$LoanApprovalQuary2 = "UPDATE `user_data` SET `loan` = '$LoanApprovalMoney', `loanInterest` = '$loanInterest', `loanTotal` = '$loanTotal' WHERE `username` = '$requestLoanUserUname'";
		$LoanApprovalResult = mysqli_query($conn, $LoanApprovalQuary);
		$LoanApprovalResult2 = mysqli_query($conn, $LoanApprovalQuary2);
		if ($LoanApprovalResult && $LoanApprovalResult2) {
			echo '<div id="snackbar">Loan given.</div>';
			echo "<script>amsFlashMessage()</script>";
			echo "<script>javascript:document.location='admin_loan.php'</script>";
		}
	} else {
		echo '<div id="snackbar">Money can\'t be NULL.</div>';
		echo "<script>amsFlashMessage()</script>";
	}
}
mysqli_close($conn);
?>