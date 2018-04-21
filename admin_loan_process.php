<?php
require 'config.php';
session_start();
if (!$_SESSION['AMS_admin_login'] || isset($_GET['name']) == '') {
	header('Location: index.php');
	exit();
}
$name = mysqli_real_escape_string($conn, $_GET['name']);
if (isset($_GET)) {
    $sqlQuery = "SELECT `money`, `loan`, `loanInterest` FROM `user_data` WHERE `username` = '$name'";
    $result= mysqli_query($conn, $sqlQuery);
    $rows = mysqli_fetch_assoc($result);
    if ($rows) {
        $userMoney = $rows['money'];
        $userLoan = $rows['loan'];
        $userInterest = $rows['loanInterest'];
    }
}
if(isset($userMoney) == NULL){
    header('location: error.php');
}
$Present_Amount;
$PA_query = "SELECT `present_Amount` FROM `ams_loan` WHERE `username` = '$name' ORDER BY `id` DESC";
$PA_result = mysqli_query($conn, $PA_query);
$PA_rows = mysqli_fetch_assoc($PA_result);
if ($PA_rows) {
    $Present_Amount = $PA_rows['present_Amount'];
} else {
    $Present_Amount = $userLoan;
}
function interestCount($loanMoney)
{
    $interestMoney = $loanMoney / 52;
    return $interestMoney;
}
$loanInstallmentMoney = intval(interestCount($userLoan));
$loanInstallmentInterest = intval(interestCount($userInterest));
$loanInstallment = $loanInstallmentMoney + $loanInstallmentInterest;
$date = date('Y-m-d');
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
        <div class="row mt-2">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h3>Loan Repayment</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="loanAmount" class="col-sm-6 col-form-label">loan Amount :</label>
                                    <div class="col-sm-6">
                                        <input type="text" readonly class="form-control-plaintext" id="loanAmount" value="<?php echo $userLoan; ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="loanAmount" class="col-sm-7 col-form-label">loan Installment :</label>
                                    <div class="col-sm-5">
                                        <input type="text" readonly class="form-control-plaintext" id="loanAmount" value="<?php echo $loanInstallment; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="loanAmount" class="col-sm-3 col-form-label">Duration :</label>
                            <div class="col-sm-9">
                                <input type="text" readonly class="form-control-plaintext" id="loanAmount" value="52">
                            </div>
                        </div>
                        <hr>
                        <form method="post">
                            <div class="form-group row">
                                <label for="inputInstallment" class="col-sm-5 col-form-label">Installment Number</label>
                                <div class="col-sm-7">
                                    <input type="number" class="form-control" name="InstallmentSerial" id="inputInstallment" placeholder="Number of Installment">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputAmount" class="col-sm-5 col-form-label">Amount</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" name="InstallmentAmount" id="inputAmount" placeholder="Amount" value="<?php echo $loanInstallment; ?>" readonly>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-outline-success float-right" name="btn_Installment">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h3>Loan Table</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Loan Amount</th>
                                    <th scope="col">Weekly Installment</th>
                                    <th scope="col">Installment Amount</th>
                                    <th scope="col">Present Amount</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Week</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $installmentData = array();
                                    $installmentSqlQuery = "SELECT `loan_Amount`, `weeklyInstallment`, `paid_Amount`, `present_Amount`, `date`, `week` FROM `ams_loan` WHERE `username` = '$name' ORDER by `id` DESC";
                                    if ($installmentResult = $conn->query($installmentSqlQuery)) {
                                        while ($installmentRows = $installmentResult->fetch_array(MYSQLI_ASSOC)) {
                                            $installmentData[] = $installmentRows;
                                        }
                                        $installmentResult->close();
                                    }
                                    //$conn->close();
                                    foreach ($installmentData as $installmentRow) {
                                        echo "<tr>";
                                        echo "<td>" . $installmentRow['loan_Amount'] . "</td>";
                                        echo "<td>" . $installmentRow['weeklyInstallment'] . "</td>";
                                        echo "<td>" . $installmentRow['paid_Amount'] . "</td>";
                                        echo "<td>" . $installmentRow['present_Amount'] . "</td>";
                                        echo "<td>" . $installmentRow['date'] . "</td>";
                                        echo "<td>" . $installmentRow['week'] . "</td>";
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
    <script>
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
    if (isset($_POST['btn_Installment'])) {
        $inst_number = $_POST['InstallmentSerial'];
        $inst_amount = $_POST['InstallmentAmount'];
        
        //echo $inst_number . " : " . $inst_amount;

        if (empty($inst_number) || empty($inst_amount)) {
            echo '<div id="snackbar">All fields are required.</div>';
            echo "<script>amsFlashMessage()</script>";
        } else {
            $Present_Amount -= $inst_amount;
            $inst_query = "INSERT INTO `ams_loan`(`id`, `username`, `loan_Amount`, `weeklyInstallment`, `paid_Amount`, `Present_Amount`, `date`, `week`) VALUES (NULL, '$name', '$userLoan', '$loanInstallment', '$inst_amount', '$Present_Amount', '$date', '$inst_number')";
            $inst_result = mysqli_query($conn, $inst_query);
            if ($inst_result) {
                echo '<div id="snackbar">Loan Installment Paid.</div>';
                echo "<script>amsFlashMessage()</script>";
                echo "<script>javascript:document.location='admin_loan_process.php?name=".$name."'</script>";
            } else {
                echo mysqli_error($conn);
                echo '<div id="snackbar">Loan Installment is not Paid.</div>';
                echo "<script>amsFlashMessage()</script>";
            }
        }
    }
?>