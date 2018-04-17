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
			<div class="col-sm-2 col-md-2 mt-2">
				<ul class="list-group">
					<div class="list-group-item list-group-item-action">
						<div class="form-group">
							<input type="text" class="form-control" id="searchUserInput" onkeyup="searchUserFunction()" placeholder="Search for user ...">
						</div>
					</div>
					<a href="admin_loan.php" class="list-group-item list-group-item-action bg-dark text-light">
						Loan Request
					</a>
					<button type="button" class="list-group-item list-group-item-action bg-dark text-light" data-toggle="modal" data-target="#AMSModalAdminReg">
						Admin Registration
					</button>
				</ul>
			</div>
			<div class="col-sm-10 col-md-10 mt-2">
				<div class="card">
					<div class="card-header">
						<h3>Users Details</h3>
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
									<th scope="col">Balance</th>
									<th scope="col" colspan="2">Loan</th>
									<th scope="col">Cash IN</th>
									<th scope="col">Cash OUT</th>
									<th scope="col">Message</th>
									<th scope="col">More Details</th>
									<th scope="col">Delete</th>
								</tr>
							</thead>
							<tbody id="searchUserList">
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
											<a href="admin_loan_process.php?name='.$row['userUsername'].'" class="btn btn-outline-primary">
												<i class="fas fa-chevron-circle-right"></i>
											</a>
										</td>
									';
									echo '
										<td>
											<a href="admin_cash_in.php?id='.$row['id'].'" class="btn btn-outline-success">
												<i class="fas fa-plus"></i>
											</a>
										</td>
										<td>
											<a href="admin_cash_out.php?id='.$row['id'].'" class="btn btn-outline-warning">
												<i class="fas fa-minus"></i>
											</a>
										</td>
									';
									echo '<td>
										<a href="admin_message.php?name='.$row['userUsername'].'" class="btn btn-text">
											<i class="fas fa-paper-plane"></i>
										</a>
									</td>';
									echo '<td>
										<a href="admin_userDetails.php?name='.$row['userUsername'].'" class="btn btn-outline-secondary">
											<i class="fas fa-info-circle"></i>
										</a>
									</td>';
									echo '
									<td>
										<button type="button" id="userDelete" class="btn btn-outline-danger" onclick="userRemove('.$row['id'].')" data-toggle="modal" data-target="#AMSModalDeleteUser">
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
			<div id="myModal" class="modal">
				<span class="close">&times;</span>
				<img class="modal-content" id="img01">
				<div id="caption"></div>
			</div>
		</div>

		<!-- Modal for delete user -->
		<div class="modal fade" id="AMSModalDeleteUser" tabindex="-1" role="dialog" aria-labelledby="AMSModalDeleteUserLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="AMSModalDeleteUserLabel">Delete User</h5>
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

		<!-- Modal for admin registration -->
		<div class="modal fade" id="AMSModalAdminReg" tabindex="-1" role="dialog" aria-labelledby="AMSModalDeleteUserLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="AMSModalDeleteUserLabel">
							New Admin Registration
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="#" method="post">
						<div class="modal-body">
							<div class="form-group">
                                <input type="text" name="adminRegName" id="name" tabindex="1" class="form-control" placeholder="Name" maxlength="50">
                            </div>
                            <div class="form-group">
                                <input type="email" name="adminRegEmail" id="email" tabindex="1" class="form-control" placeholder="Email Address" maxlength="50">
                            </div>
                            <div class="form-group">
                                <input type="text" name="adminRegUsername" id="regusername" tabindex="1" class="form-control" placeholder="Username" maxlength="30">
                            </div>
                            <div class="form-group">
                                <input type="password" name="adminRegPassword" id="regpassword" tabindex="2" class="form-control" placeholder="Password" maxlength="50">
                            </div>
                            <div class="form-group">
                                <input type="password" name="adminRegConpassword" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" maxlength="50">
                            </div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							<button type="submit" name="adminRegistration" id="register-submit"	 class="btn btn-success">Registration</button>
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
		function amsFlashMessage() {
		    var x = document.getElementById("snackbar")
		    x.className = "show";
		    setTimeout(function(){
		    	x.className = x.className.replace("show", "");
		    }, 3000);
		}
		function searchUserFunction() {
			// Declare variables
			var input, filter, ul, li, a, i;
			input = document.getElementById('searchUserInput');
			filter = input.value.toUpperCase();
			ul = document.getElementById("searchUserList");
			li = ul.getElementsByTagName('tr');

			// Loop through all list items, and hide those who don't match the search query
			for (i = 0; i < li.length; i++) {
				a = li[i].getElementsByTagName("td")[0];
				if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
					li[i].style.display = "";
				} else {
					li[i].style.display = "none";
				}
			}
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
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adminRegistration'])) {
    $adminName              = validate_input($_POST['adminRegName']);
    $adminUsername          = validate_input($_POST['adminRegUsername']);
    $adminEmail             = validate_input($_POST['adminRegEmail']);
    $adminPassword          = validate_input($_POST['adminRegPassword']);
    $adminConPassword       = validate_input($_POST['adminRegConpassword']);
    //echo $adminName . " : " . $adminUsername . " : " . $adminEmail . " : " . $adminPassword . " : " . $adminConPassword;
    if (empty($adminName) || empty($adminUsername) || empty($adminEmail) || empty($adminPassword) || empty($adminConPassword)) {
        echo '<div id="snackbar">All fields are required.</div>';
		echo "<script>amsFlashMessage()</script>";
    } else {
        if ($adminPassword != $adminConPassword) {
            echo '<div id="snackbar">Password not matched.</div>';
			echo "<script>amsFlashMessage()</script>";
        } else {
            if (filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
                $adminPassword = password_hash($adminConPassword, PASSWORD_BCRYPT);
                //echo "<br>" . $adminPassword;
                $adminRegQuery = "INSERT INTO `admin_info`(`id`, `adminName`, `adminEmail`, `adminUsername`, `adminPassword`) VALUE (NULL, '$adminName', '$adminEmail', '$adminUsername', '$adminPassword')";
                $adminRegResult = mysqli_Query($conn, $adminRegQuery);
                if ($adminRegResult) {
                    echo '<div id="snackbar">New Admin Successfully Registered.</div>';
					echo "<script>amsFlashMessage()</script>";
                }else{
                    echo '<div id="snackbar">New Admin Registration Failed.</div>';
					echo "<script>amsFlashMessage()</script>";
                    //echo mysqli_error($conn);
                }
            } else {
                echo '<div id="snackbar">Email address is not valid.</div>';
				echo "<script>amsFlashMessage()</script>";
            }
        }
    }
}
?>