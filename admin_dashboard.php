<?php

require 'config.php';
session_start();
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
	<style>
		.userPhoto{
			cursor: zoom-in;
			width: 45px;
		}
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
							<i class="fas fa-home"></i>
							HOME
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
		$data = array();
		$sqlquery = "SELECT * FROM `user_info` INNER JOIN `user_data` ON `user_info`.`userUsername` = `user_data`.`username`";
		if ($result = $conn->query($sqlquery)) {
			while ($rows = $result->fetch_array(MYSQLI_ASSOC)) {
				$data[] = $rows;
			}
			$result->close();
		}
		//$conn->close();
	?>
	<main role="main" class="container-fluid">

		<div class="modal fade" id="enlargeImageModal" tabindex="-1" role="dialog" aria-labelledby="enlargeImageModal" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
					</div>
					<div class="modal-body">
						<img src="" class="enlargeImageModalSource" style="width: 60%;">
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-2 mt-4">
				<ul class="list-group">
					<a href="#" class="list-group-item list-group-item-action">Admin Registration</a>
					<a href="admin_loan.php" class="list-group-item list-group-item-action">Loan Request</a>
				</ul>
			</div>
			<div class="col-md-10 mt-4">
				<div class="card">
					<div class="card-header">
						<h3>User Details</h3>
					</div>
					<div class="card-body depoMoney">
						<table class="table table-hover table-sm table-bordered table-striped">
							<thead>
								<tr>
									<th scope="col">Photo</th>
									<th scope="col">Name</th>
									<th scope="col">Email</th>
									<th scope="col">Phone</th>
									<th scope="col">NID Card</th>
									<th scope="col">Amount</th>
									<th scope="col" colspan="2">Loan</th>
									<th scope="col">Cash IN</th>
									<th scope="col">Cash OUT</th>
									<th scope="col">Message</th>
									<th scope="col">Action</th>
									<th scope="col">More Details</th>
								</tr>
							</thead>
							<tbody>
								<?php

								foreach ($data as $row) {
									echo "<tr>";
									echo '<td><img class="userPhoto" src="asset/img/userphoto/'.$row['userPhoto'].'" alt="'.ucfirst($row['userName']).'"></td>';
									echo "<td>" . ucfirst($row['userName']) . "</td>";
									echo "<td>" . $row['userEmail'] . "</td>";
									echo "<td>" . $row['userPhone'] . "</td>";
									echo '<td><img class="userPhoto" src="asset/img/usernid/'.$row['userNid'].'" alt=""></td>';
									echo "<td>" . $row['money'] . "</td>";
									echo "<td>" . $row['loan'] . "</td>";
									echo '
										<td>
											<a href="admin_loan_process.php?id='.$row['id'].'" class="btn btn-primary">
												<i class="fas fa-chevron-circle-right"></i>
											</a>
										</td>
									';
									echo '
										<td>
											<a href="admin_cash_in.php?id='.$row['id'].'" class="btn btn-success">
												<i class="fas fa-plus"></i>
											</a>
										</td>
										<td>
											<a href="admin_cash_out.php?id='.$row['id'].'" class="btn btn-warning">
												<i class="fas fa-minus"></i>
											</a>
										</td>
									';
									echo '<td>
										<a href="admin_message.php?name='.$row['userUsername'].'" class="btn btn-text">
											<i class="fas fa-paper-plane"></i>
										</a>
									</td>';
									echo '
									<td>
										<button type="button" id="userDelete" class="btn btn-danger" onclick="userRemove('.$row['id'].')" data-toggle="modal" data-target="#AMSModal">
											<i class="fas fa-trash-alt"></i>
										</button>
									</td>
									';
									echo "<td></td>";
									echo "</tr>";
								}

								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div id="myModal" class="modal">
				<span class="close">&times;</span>
				<img class="modal-content" id="img01">
				<div id="caption"></div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="AMSModal" tabindex="-1" role="dialog" aria-labelledby="AMSModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="AMSModalLabel">Delete User</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="#" method="post">
						<div class="modal-body">
							<p>Do you want to delete this user?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-success" data-dismiss="modal">No, Close</button>
							<button type="submit" class="btn btn-danger" name="deleteUser">Yes, Delete</button>
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
    	function userRemove(id){
    		document.cookie="deleteUserId="+id;
    	}
    	$(function() {
	    	$('img').on('click', function() {
				$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
				$('#enlargeImageModal').modal('show');
			});
		});
    </script>
</body>
</html>
<?php
if (isset($_POST['deleteUser'])) {
	$deleteUserId = $_COOKIE['deleteUserId'];
	echo $deleteUserId;
	$deleteUserQuery1 = "DELETE FROM `user_info` WHERE `id` = '$deleteUserId'";
	$deleteUserQuery2 = "DELETE FROM `user_data` WHERE `id` = '$deleteUserId'";
    $deleteUserResult1 = mysqli_query($conn, $deleteUserQuery1);
    $deleteUserResult2 = mysqli_query($conn, $deleteUserQuery2);
    if ($deleteUserResult1 && $deleteUserResult2) {
        //setcookie('bookId', '', time() - 3600);
        echo '<script>document.cookie = "bookId=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";</script>';
        echo "<script>javascript:document.location='admin_dashboard.php'</script>";
    } else {
        echo "<script>document.getElementById('error').innerHTML = 'Failed to Delete user.' </script>";
    }
}
?>