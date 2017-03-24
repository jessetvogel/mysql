<?php

require('mysql.php');

$database = $_GET['database'];
$databases = databases($mysqli);
if(!in_array($database, $databases)) {
  echo "[]";
  exit;
}

echo json_encode(tables($mysqli, $database));

?>
