<?php
require 'config.php';
session_start();
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
        $userLoan = $rows['loan'];
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
        <div class="row mt-2">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3>Loan Repayment</h3>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="form-group row">
                                <label for="inputInstalment" class="col-sm-5 col-form-label">Instalment Number</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="instalmentSerial" id="inputInstalment" placeholder="Number of Instalment">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputAmount" class="col-sm-5 col-form-label">Amount</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="instalmentAmount" id="inputAmount" placeholder="Amount">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-success float-right" name="btn_instalment">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h3>Loan Table</h3>
                    </div>
                    <div class="card-body"></div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
<?php
    if (isset($_POST['btn_instalment'])) {
        
    }
?>