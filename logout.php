<?php
session_start();
if (isset($_SESSION['AMS_admin_login']) || isset($_SESSION['AMS_user_login'])) {
	session_destroy();
	header('Location: index.php');
}

?>