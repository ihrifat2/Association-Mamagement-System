<?php

require 'config.php';
session_start();
if (!$_SESSION['AMS_admin_login'] || isset($_GET['name']) == '') {
	header('Location: index.php');
	exit();
}
$username = $_SESSION['AMS_admin_login'];
if (isset($_GET)) {
    $name = mysqli_real_escape_string($conn, $_GET['name']);
    $sqlQuery = "SELECT `userUsername` FROM `user_info` WHERE `userUsername` = '$name'";
    $result= mysqli_query($conn, $sqlQuery);
    $rows = mysqli_fetch_assoc($result);
    if ($rows) {
        $userUsername = $rows['userUsername'];
    }
}
if(isset($userUsername) == NULL){
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
	<style>
		#searchUserList {
			list-style-type: none;
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
		$amsDataUL = array();
		$amsSqlQueryUL = "SELECT `userName`, `userUsername` FROM `user_info`";
		if ($amsResultUL = $conn->query($amsSqlQueryUL)) {
			while ($rowsUL = $amsResultUL->fetch_array(MYSQLI_ASSOC)) {
				$amsDataUL[] = $rowsUL;
			}
			$amsResultUL->close();
		}
		//$conn->close();
	?>
	<main role="main" class="container">

		<div class="row">
			<div class="col-sm-3 mt-2">
				<div class="card">
					<div class="card-header">
						<div class="form-group">
							<input type="text" class="form-control" id="searchUserInput" onkeyup="searchUserFunction()" placeholder="Search for user">
						</div>
					</div>
					<div class="card-body amsMessageChat">
						<ul class="list-group" id="searchUserList">
							<?php
								foreach ($amsDataUL as $rowUL) {
									echo '<li>
										<a class="list-group-item list-group-item-action" href="admin_message.php?name='.$rowUL['userUsername'].'">
												'. ucfirst($rowUL['userName']) . '
										</a>
									</li>';
								}
							?>
						</ul>
					</div>
				</div>
			</div>
			<?php
				$amsDatachat = array();
				$amsSqlQuerychat = "SELECT `sender`, `message` FROM `ams_chat` WHERE `sender` = '$userUsername' AND `receiver` = 'admin' OR `sender` = 'admin' AND `receiver` = '$userUsername'";
				if ($amsResultchat = $conn->query($amsSqlQuerychat)) {
					while ($rowschat = $amsResultchat->fetch_array(MYSQLI_ASSOC)) {
						$amsDatachat[] = $rowschat;
					}
					$amsResultchat->close();
				}
				//$conn->close();
			?>
			<div class="col-sm-9 mt-2">
				<div class="card">
					<div class="card-header">
						<h3>Message</h3>
					</div>
					<div class="card-body amsMessageBody">
						<div class="row">
							<?php
								foreach ($amsDatachat as $rowChat) {
									?>
									<div class="col-sm-1">
										<span class="badge badge-pill badge-dark">
											<?php echo $rowChat['sender']; ?>
										</span>
									</div>
									<div class="col-sm-11 text-justify">
										<?php echo $rowChat['message']; ?>
									</div>
									<?php
								}
							?>
						</div>
					</div>
					<div class="card-footer">
						<form action="#" method="post">
							<div class="form-group">
								<textarea class="form-control" name="txtmessage" id="sendMessage" rows="2"></textarea>
							</div>
							<div class="form-group">
								<button type="submit" class="float-left btn btn-outline-success" name="txtmessageBtn">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

	</main>
    <script src="asset/js/jquery-slim.min.js"></script>
    <script src="asset/js/popper.min.js"></script>
	<script src="asset/js/bootstrap.min.js"></script>
	<script>
		function amsFlashMessage() {
		    var x = document.getElementById("snackbar")
		    x.className = "show";
		    setTimeout(function(){
		    	x.className = x.className.replace("show", "");
		    	// document.location='admin_dashboard.php';
		    }, 3000);
		}
		function searchUserFunction() {
			// Declare variables
			var input, filter, ul, li, a, i;
			input = document.getElementById('searchUserInput');
			filter = input.value.toUpperCase();
			ul = document.getElementById("searchUserList");
			li = ul.getElementsByTagName('li');

			// Loop through all list items, and hide those who don't match the search query
			for (i = 0; i < li.length; i++) {
				a = li[i].getElementsByTagName("a")[0];
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
if (isset($_POST['txtmessageBtn'])) {
	$message = validate_input($_POST['txtmessage']);
	if (!empty($message)) {
		$messageQuery = "INSERT INTO `ams_chat`(`id`, `sender`, `message`, `receiver`) VALUES (NULL,'$username','$message','$userUsername')";
		$messageResult = mysqli_query($conn, $messageQuery);
		if ($messageResult) {
			echo "<script>javascript:document.location='admin_message.php?name=".$userUsername."'</script>";
		} else {
			echo '<div id="snackbar">Failed to Send Message.</div>';
			echo "<script>amsFlashMessage()</script>";
		}
	} else {
		echo '<div id="snackbar">Write some message.</div>';
		echo "<script>amsFlashMessage()</script>";
	}
}
mysqli_close($conn);
?>