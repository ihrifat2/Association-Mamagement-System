<?php
require 'config.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="asset/css/bootstrap3.min.css">
    <link rel="stylesheet" type="text/css" href="asset/css/style.css">
</head>
<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><?php echo $project_name; ?></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item mr-2">
                        <a class="nav-link btn btn-outline-secondary text-light" href="admin_login.php">Admin Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-secondary text-light" href="user_login.php">User Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container login">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="#" class="active" id="login-form-link">Admin Login</a>
                            </div>
                            <div class="col-xs-6">
                                <a href="#" id="admin_login-link">Admin Registration</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="login-form" action="#" method="post" role="form" style="display: block;" autocomplete="off">
                                    <div class="form-group">
                                        <input type="text" name="adminLogUname" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="adminLogPasswd" id="password" tabindex="2" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="adminLogin" id="login-submit" tabindex="4" class="form-control btn btn-login" value="Login">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <p id="error" class="error"></p>
                                        <p id="success" class="success"></p>
                                    </div>
                                </form>
                                
                                <form id="admin_login" action="#" method="post" role="form" style="display: none;" autocomplete="off">
                                    <div class="form-group">
                                        <input type="text" name="adminRegName" id="name" tabindex="1" class="form-control" placeholder="Name" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="adminRegUsername" id="regusername" tabindex="1" class="form-control" placeholder="Username" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="adminRegEmail" id="email" tabindex="1" class="form-control" placeholder="Email Address" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="adminRegPassword" id="regpassword" tabindex="2" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="adminRegConpassword" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="adminRegistration" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Registration">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="asset/js/jquery-slim.min.js"></script>
    <script src="asset/js/popper.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        $(function() {

            $('#login-form-link').click(function(e) {
                $("#login-form").delay(100).fadeIn(100);
                $("#admin_login").fadeOut(100);
                $('#admin_login-link').removeClass('active');
                $(this).addClass('active');
                e.preventDefault();
            });
            $('#admin_login-link').click(function(e) {
                $("#admin_login").delay(100).fadeIn(100);
                $("#login-form").fadeOut(100);
                $('#login-form-link').removeClass('active');
                $(this).addClass('active');
                e.preventDefault();
            });

        });
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adminLogin'])) {
    $username = $_POST['adminLogUname'];
    $password = $_POST['adminLogPasswd'];
    if (empty($username) || empty($password)) {
        echo "<script>document.getElementById('error').innerHTML = 'All Field are required.';</script>";
    } else {
        $logQuery = "SELECT * FROM `admin_info` WHERE `adminUsername` = '$username'";
        $logResult= mysqli_Query($conn, $logQuery);
        $logRows = mysqli_fetch_assoc($logResult);
        $store_password = $logRows['adminPassword'];
        $check = password_verify($password, $store_password);
        if ($check) {
            $_SESSION['AMS_admin_login'] = $username;
            // header("Location: admin_dashboard.php");
            echo "<script>javascript:document.location='admin_dashboard.php'</script>";
        } else {
            echo '<script>document.getElementById("error").innerHTML="Username or Password is incorrect"</script>';
        }
    }
} 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adminRegistration'])) {
    $adminName              = validate_input($_POST['adminRegName']);
    $adminUsername          = validate_input($_POST['adminRegUsername']);
    $adminEmail             = validate_input($_POST['adminRegEmail']);
    $adminPassword          = validate_input($_POST['adminRegPassword']);
    $adminConPassword       = validate_input($_POST['adminRegConpassword']);
    //echo $adminUsername . " : " . $adminEmail . " : " . $adminPassword . " : " . $adminConPassword;
    if (empty($adminName) || empty($adminUsername) || empty($adminEmail) || empty($adminPassword) || empty($adminConPassword)) {
        echo '<script>document.getElementById("error").innerHTML="All fields are required."</script>';
    } else {
        if ($adminPassword != $adminConPassword) {
            echo '<script>document.getElementById("error").innerHTML="Password not matched."</script>';
        } else {
            if (filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
                $adminPassword = password_hash($adminConPassword, PASSWORD_BCRYPT);
                //echo "<br>" . $adminPassword;
                $adminRegQuery = "INSERT INTO `admin_info`(`id`, `adminName`, `adminEmail`, `adminUsername`, `adminPassword`) VALUE (NULL, '$adminName', '$adminEmail', '$adminUsername', '$adminPassword')";
                $adminRegResult = mysqli_Query($conn, $adminRegQuery);
                if ($adminRegResult) {
                    echo '<script>document.getElementById("success").innerHTML="Successfully Registered."</script>';
                }else{
                    echo '<script>document.getElementById("error").innerHTML="Registered Failed."</script>';
                    //echo mysqli_error($conn);
                }
            } else {
                echo '<script>document.getElementById("error").innerHTML="Email address is not valid."</script>';
            }
        }
    }
}

?>

