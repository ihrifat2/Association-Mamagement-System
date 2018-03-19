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
	<?php

		$data = array();
		$sqlquery = "SELECT `id`, `userName`, `userEmail` FROM `user_info`";
		if ($result = $conn->query($sqlquery)) {
			while ($rows = $result->fetch_array(MYSQLI_ASSOC)) {
				$data[] = $rows;
			}
			$result->close();
		}
		//$conn->close();
	
	?>
	<main role="main" class="container-fluid my-2">

		<div class="row">
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h3>User List</h3>
					</div>
					<div class="card-body depoMoney">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Name</th>
									<th>Email</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php

								foreach ($data as $row) {
									echo "<tr>";
									echo "<td>" . ucfirst($row['userName']) . "</td>";
									echo "<td>" . $row['userEmail'] . "</td>";
									echo '
									<td>
										<a href="admin_edit.php?id='.$row['id'].'" class="btn btn-info">
											<i class="fas fa-edit"></i>
										</a>
										<button type="button" id="userDelete" class="btn btn-danger" onclick="userRemove('.$row['id'].')" data-toggle="modal" data-target="#AMSModal">
											<i class="fas fa-trash-alt"></i>
										</button>
									</td>
									';
									echo "</tr>";
								}

								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<?php

				$data = array();
				$sqlquery = "SELECT `id`, `username`, `money`, `loan` FROM `user_data`";
				if ($result = $conn->query($sqlquery)) {
					while ($rows = $result->fetch_array(MYSQLI_ASSOC)) {
						$data[] = $rows;
					}
					$result->close();
				}
				//$conn->close();
			
			?>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header">
						<h3>User Details</h3>
					</div>
					<div class="card-body depoMoney">
						<table class="table table-hover">
							<thead>
								<tr>
									<th>Name</th>
									<th>Ammount</th>
									<th>Loan</th>
									<th>Cash IN</th>
									<th>Cash OUT</th>
								</tr>
							</thead>
							<tbody>
								<?php

									foreach ($data as $row) {
										echo "<tr>";
										echo "<td>" . ucfirst($row['username']) . "</td>";
										echo "<td>" . $row['money'] . "</td>";
										echo "<td>" . $row['loan'] . "</td>";
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
        echo "<script>document.getElementById('success').innerHTML = 'User Deleted.' </script>";
    } else {
        echo "<script>document.getElementById('error').innerHTML = 'Failed to Delete user.' </script>";
    }
}
?>