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
    <main role="main" class="container">
        <div class="row justify-content-md-center border border-warning mt-3">
            <div class="col-sm-3 border border-danger">1</div>
            <div class="col-sm-3 border border-danger">2</div>
            <div class="col-sm-3 border border-danger">3</div>
            <div class="col-sm-3 border border-danger">4</div>
            </div>
        </div>
    </main>
</body>
</html>