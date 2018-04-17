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
                                <a href="#" class="active" id="login-form-link">User Login</a>
                            </div>
                            <div class="col-xs-6">
                                <a href="#" id="admin_login-link">User Registration</a>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="login-form" action="#" method="post" role="form" style="display: block;" autocomplete="off">
                                    <div class="form-group">
                                        <input type="text" name="userLogUname" id="username" tabindex="1" class="form-control" placeholder="Username" maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="userLogPasswd" id="password" tabindex="2" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="userLogin" id="login-submit" tabindex="4" class="form-control btn btn-login" value="LogIn">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <p id="error" class="error"></p>
                                        <p id="success" class="success"></p>
                                    </div>
                                </form>
                                
                                <form id="admin_login" action="#" method="post" role="form" style="display: none;" autocomplete="off" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <input type="text" name="userRegName" id="name" tabindex="1" class="form-control" placeholder="Name" maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="userRegEmail" id="email" tabindex="1" class="form-control" placeholder="Email Address" maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="userRegPhone" id="phone" tabindex="1" class="form-control" placeholder="Phone" maxlength="50">
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
                                        <input type="text" name="userRegUsername" id="regusername" tabindex="1" class="form-control" placeholder="Username" maxlength="30">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="userRegPassword" id="regpassword" tabindex="2" class="form-control" placeholder="Password" maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="userRegConpassword" id="confirm-password" tabindex="2" class="form-control" placeholder="Confirm Password" maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="userRegistration" id="register-submit" tabindex="4" class="form-control btn btn-register" value="Registration">
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
    <script src="asset/js/jquery-3.3.1.min.js"></script>

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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userLogin'])) {
    $username = $_POST['userLogUname'];
    $password = $_POST['userLogPasswd'];
    if (empty($username) || empty($password)) {
        echo "<script>document.getElementById('demoo').innerHTML = 'All Field are required.';</script>";
    } else {
        $logQuery = "SELECT * FROM `user_info` WHERE `userUsername` = '$username'";
        $logResult= mysqli_Query($conn, $logQuery);
        $logRows = mysqli_fetch_assoc($logResult);
        $store_password = $logRows['userPassword'];
        $check = password_verify($password, $store_password);
        if ($check) {
            $_SESSION['AMS_user_login'] = $username;
            // header("Location: user_dashboard.php");
            echo "<script>javascript:document.location='user_dashboard.php'</script>";
            echo '<script>document.getElementById("error").innerHTML="OK."</script>';
        } else {
            echo '<script>document.getElementById("error").innerHTML="Username or Password is incorrect"</script>';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userRegistration'])) {
    $userName              = validate_input($_POST['userRegName']);
    $userEmail             = validate_input($_POST['userRegEmail']);
    $userPhone             = validate_input($_POST['userRegPhone']);
    $userUsername          = validate_input($_POST['userRegUsername']);
    $userPassword          = validate_input($_POST['userRegPassword']);
    $userConPassword       = validate_input($_POST['userRegConpassword']);

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
    //echo $userUsername . " : " . $userEmail . " : " . $userPassword . " : " . $userConPassword;
    
    if (empty($userName) || empty($userEmail) || empty($userPhone) || empty($userUsername) || empty($userPassword) || empty($userConPassword)) {
        echo '<script>document.getElementById("error").innerHTML="All fields are required."</script>';
    } else {
        if ($userPassword != $userConPassword) {
            echo '<script>document.getElementById("error").innerHTML="Password not matched."</script>';
        } else {
            if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                if (move_uploaded_file($userPhoto_tmp, $userPhoto_dir . $userPhoto_name) && move_uploaded_file($userNid_tmp, $userNid_dir . $userNid_name)) {
                    $userPassword = password_hash($userConPassword, PASSWORD_BCRYPT);
                    $money = 0;
                    $loan = 0;
                    $userRegQuery1 = "INSERT INTO `user_info`(`id`, `userName`, `userEmail`, `userPhone`, `userPhoto`, `userNid`, `userUsername`, `userPassword`) VALUE (NULL, '$userName', '$userEmail', '$userPhone', '$userPhoto_name', '$userNid_name', '$userUsername', '$userPassword')";
                    $userRegQuery2 = "INSERT INTO `user_data`(`id`, `username`, `money`, `loan`) VALUES (NULL, '$userUsername', '$money', '$loan')";
                    $userRegResult1 = mysqli_Query($conn, $userRegQuery1);
                    $userRegResult2 = mysqli_Query($conn, $userRegQuery2);
                    if ($userRegResult1 && $userRegResult2) {
                        echo '<script>document.getElementById("success").innerHTML="Successfully Registered."</script>';
                    }else{
                        echo '<script>document.getElementById("error").innerHTML="Registered Failed."</script>';
                        echo mysqli_error($conn);
                    }
                } else {
                    echo '<script>document.getElementById("error").innerHTML="Photo Upload Failed."</script>';
                }
            } else {
                echo '<script>document.getElementById("error").innerHTML="Email address is not valid."</script>';
            }
        }
    }
}
