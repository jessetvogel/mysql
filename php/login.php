<?php

require('mysql.php');

if(!isset($_POST['host']) ||
   !isset($_POST['username']) ||
   !isset($_POST['password'])) {
     // No valid request
     exit();
}

// Check if we can log in
$mysqli = connect($_POST['host'], $_POST['username'], $_POST['password']);
$mysqli->close();

// If we succeeded, save the login information
$_SESSION['login']['host'] = $_POST['host'];
$_SESSION['login']['username'] = $_POST['username'];
$_SESSION['login']['password'] = $_POST['password'];

echo "true";

?>
