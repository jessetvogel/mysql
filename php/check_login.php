<?php

require('mysql.php');

if(!isset($_SESSION['login'])) {
  exit();
}

$mysqli = connect($host, $username, $password);
$mysqli->close();

echo "true";

?>
