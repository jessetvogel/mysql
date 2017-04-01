<?php

require('mysql.php');

$mysqli = connect($host, $username, $password);

$database = $_GET['database'];
$databases = databases($mysqli);
if(!in_array($database, $databases)) {
  echo "[]";
  exit;
}

echo json_encode(tables($mysqli, $database));

?>
