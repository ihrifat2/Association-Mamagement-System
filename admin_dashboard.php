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
	<title>Admin Dashboard | <?php echo $project_name; ?></title>
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
		$UD_data = array();
		$UD_sqlquery = "SELECT * FROM `user_info` INNER JOIN `user_data` ON `user_info`.`userUsername` = `user_data`.`username`";
		if ($UD_result = $conn->query($UD_sqlquery)) {
			while ($UD_rows = $UD_result->fetch_array(MYSQLI_ASSOC)) {
				$UD_data[] = $UD_rows;
			}
			$UD_result->close();
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
					<button type="button" class="list-group-item list-group-item-action bg-dark text-light" data-toggle="modal" data-target="#AMSModalUserReg">
						User Registration
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

								foreach ($UD_data as $UD_row) {
									echo "<tr>";
									echo '<td><img class="userPhoto" src="asset/img/userphoto/'.$UD_row['userPhoto'].'" alt="'.ucfirst($UD_row['userName']).'"></td>';
									echo "<td>" . ucfirst($UD_row['userName']) . "</td>";
									echo "<td>" . $UD_row['userEmail'] . "</td>";
									echo "<td>" . $UD_row['userPhone'] . "</td>";
									echo '<td><img class="userPhoto" src="asset/img/usernid/'.$UD_row['userNid'].'" alt=""></td>';
									echo "<td>" . $UD_row['money'] . "</td>";
									echo "<td>" . $UD_row['loan'] . "</td>";
									echo '
										<td>
											<a href="admin_loan_process.php?name='.$UD_row['userUsername'].'" class="btn btn-outline-primary">
												<i class="fas fa-chevron-circle-right"></i>
											</a>
										</td>
									';
									echo '
										<td>
											<a href="admin_cash_in.php?id='.$UD_row['id'].'" class="btn btn-outline-success">
												<i class="fas fa-plus"></i>
											</a>
										</td>
										<td>
											<a href="admin_cash_out.php?id='.$UD_row['id'].'" class="btn btn-outline-warning">
												<i class="fas fa-minus"></i>
											</a>
										</td>
									';
									echo '<td>
										<a href="admin_message.php?name='.$UD_row['userUsername'].'" class="btn btn-text">
											<i class="fas fa-paper-plane"></i>
										</a>
									</td>';
									echo '<td>
										<a href="admin_userDetails.php?name='.$UD_row['userUsername'].'" class="btn btn-outline-secondary">
											<i class="fas fa-info-circle"></i>
										</a>
									</td>';
									echo '
									<td>
										<button type="button" id="userDelete" class="btn btn-outline-danger" onclick="userRemove(\''.$UD_row['id'].'\',\''.$UD_row['userPhoto'].'\',\''.$UD_row['userNid'].'\')" data-toggle="modal" data-target="#AMSModalDeleteUser">
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

		<!-- Modal for user registration -->
		<div class="modal fade" id="AMSModalUserReg" tabindex="-1" role="dialog" aria-labelledby="AMSModalDeleteUserLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="AMSModalDeleteUserLabel">
							New User Registration
						</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="#" method="post" enctype="multipart/form-data">
						<div class="modal-body">
							<div class="form-group">
                                <input type="text" name="userRegName" id="name" tabindex="1" class="form-control" placeholder="Name" maxlength="50">
                            </div>
                            <div class="form-group">
                                <input type="email" name="userRegEmail" id="email" tabindex="1" class="form-control" placeholder="Email Address" maxlength="50">
                            </div>
                            <div class="form-group">
                                <input type="number" name="userRegPhone" id="phone" tabindex="1" class="form-control" placeholder="Phone" maxlength="50">
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-md">
                                    <span class="input-group-addon" id="photo">Photo</span>
                                    <input type="file" class="form-control" name="userRegPhoto">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-md">
                                    <span class="input-group-addon" id="nid">NID</span>
                                    <input type="file" class="form-control" name="userRegNID">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" name="userReference" id="regReference" tabindex="1" class="form-control" placeholder="Reference" maxlength="30">
                            </div>
                            <div class="form-group">
                                <input type="text" name="userRegUsername" id="regusername" tabindex="1" class="form-control" placeholder="Username" maxlength="30">
                            </div>
                            <div class="form-group">
                                <input type="password" name="userRegPassword" id="regpassword" tabindex="2" class="form-control" placeholder="Password" maxlength="50">
                            </div>
                            <div class="form-group">
                                <input type="password" name="userRegConpassword" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" maxlength="50">
                            </div>
							<div class="modal-footer">
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								<button type="submit" name="userRegistration" id="register-submit"	 class="btn btn-success">Registration</button>
							</div>
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
		//create cookie for delete user
    	function userRemove(id, uimg, unid){
    		document.cookie="deleteUserId="+id;
    		document.cookie="deleteUserImg="+uimg;
    		document.cookie="deleteUserNid="+unid;
    		console.log(id);
    		console.log(uimg);
    		console.log(unid);
    	}
    	//view photo
    	$(function() {
	    	$('img').on('click', function() {
				$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
				$('#enlargeImageModal').modal('show');
			});
		});
		/*snackbar for flash message with redirect*/
		function amsFlashRedirect() {
		    var x = document.getElementById("snackbar")
		    x.className = "show";
		    setTimeout(function(){
		    	x.className = x.className.replace("show", "");
		    	document.location='admin_dashboard.php';
		    }, 3000);
		}
		/*snackbar for flash message without redirect*/
		function amsFlashMessage() {
		    var x = document.getElementById("snackbar")
		    x.className = "show";
		    setTimeout(function(){
		    	x.className = x.className.replace("show", "");
		    }, 3000);
		}
		/*Search user*/
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
// validate user input
function validate_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// Delete user
if (isset($_POST['deleteUser'])) {
	$deleteUserId = $_COOKIE['deleteUserId'];
	$deleteUserImg = $_COOKIE['deleteUserImg'];
	$deleteUserNid = $_COOKIE['deleteUserNid'];
	$deleteUserQuery1 = "DELETE FROM `user_info` WHERE `id` = '$deleteUserId'";
	$deleteUserQuery2 = "DELETE FROM `user_data` WHERE `id` = '$deleteUserId'";
    $deleteUserResult1 = mysqli_query($conn, $deleteUserQuery1);
    $deleteUserResult2 = mysqli_query($conn, $deleteUserQuery2);
    if ($deleteUserResult1 && $deleteUserResult2) {
        //setcookie('bookId', '', time() - 3600);
        unlink('asset/img/userphoto/'.$deleteUserImg);
        unlink('asset/img/usernid/'.$deleteUserNid);
        echo '<script>document.cookie = "bookId=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";</script>';
        echo '<div id="snackbar">User Removed.</div>';
		echo "<script>amsFlashRedirect()</script>";
    } else {
    	echo '<div id="snackbar">Failed to Delete user.</div>';
		echo "<script>amsFlashMessage()</script>";
    }
}
//new admin registration
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
//new user registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userRegistration'])) {
    $userName              	= validate_input($_POST['userRegName']);
    $userEmail             	= validate_input($_POST['userRegEmail']);
    $userPhone             	= validate_input($_POST['userRegPhone']);
    $userReference			= validate_input($_POST['userReference']);
    $userUsername          	= validate_input($_POST['userRegUsername']);
    $userPassword          	= validate_input($_POST['userRegPassword']);
    $userConPassword       	= validate_input($_POST['userRegConpassword']);

    /*User Photo*/
    $userPhoto_dir = "asset/img/userphoto/";
    $userPhoto_name = md5( $userUsername . ":" . $userPassword ) . '.' . 'jpg';
    $userPhoto_tmp  = $_FILES[ 'userRegPhoto' ][ 'tmp_name' ];
    $userPhoto_type = strtolower(pathinfo($userPhoto_name,PATHINFO_EXTENSION));


    /*User NID Card*/
    $userNid_dir = "asset/img/usernid/";
    $userNid_name = md5( $userEmail . ":" . $userPhone ) . '.' . 'jpg';
    $userNid_tmp  = $_FILES[ 'userRegNID' ][ 'tmp_name' ];
    $userNid_type = strtolower(pathinfo($userNid_name,PATHINFO_EXTENSION));
    
    // echo $userPhoto_name . " : " . $userPhoto_tmp . " : " . $userPhoto_type;
    // echo "<br>";
    // echo $userNid_name . " : " . $userNid_tmp . " : " . $userNid_type;
    // echo $userUsername . " : " . $userEmail . " : " . $userPassword . " : " . $userConPassword;
    
    //If inputs are empty
    if (empty($userName) || empty($userEmail) || empty($userPhone) || empty($userUsername) || empty($userPassword) || empty($userConPassword)) {
        echo '<div id="snackbar">All fields are required.</div>';
		echo "<script>amsFlashMessage()</script>";
    } else {
    	//If passwords are not match
        if ($userPassword != $userConPassword) {
            echo '<div id="snackbar">Password not matched.</div>';
			echo "<script>amsFlashMessage()</script>";
        } else {
        	//If email is invalid
            if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                if (move_uploaded_file($userPhoto_tmp, $userPhoto_dir . $userPhoto_name) && move_uploaded_file($userNid_tmp, $userNid_dir . $userNid_name)) {
                    $userPassword = password_hash($userConPassword, PASSWORD_BCRYPT);
                    $money = 0;
                    $loan = 0;
                    $userRegQuery1 = "INSERT INTO `user_info`(`id`, `userName`, `userEmail`, `userPhone`, `userPhoto`, `userNid`, `userReference`, `userUsername`, `userPassword`) VALUE (NULL, '$userName', '$userEmail', '$userPhone', '$userPhoto_name', '$userNid_name', '$userReference', '$userUsername', '$userPassword')";
                    $userRegQuery2 = "INSERT INTO `user_data`(`id`, `username`, `money`, `loan`) VALUES (NULL, '$userUsername', '$money', '$loan')";
                    $userRegResult1 = mysqli_Query($conn, $userRegQuery1);
                    $userRegResult2 = mysqli_Query($conn, $userRegQuery2);
                    if ($userRegResult1 && $userRegResult2) {
                    	echo '<div id="snackbar">New User Successfully Registered.</div>';
						echo "<script>amsFlashRedirect()</script>";
                    }else{
                        echo '<div id="snackbar">New User Registration Failed.</div>';
						echo "<script>amsFlashMessage()</script>";
                        echo mysqli_error($conn);
                    }
                } else {
                    echo '<div id="snackbar">Photo Upload Failed.</div>';
					echo "<script>amsFlashMessage()</script>";
                }
            } else {
                echo '<div id="snackbar">Email address is not valid.</div>';
				echo "<script>amsFlashMessage()</script>";
            }
        }
    }
}
mysqli_close($conn);
?>