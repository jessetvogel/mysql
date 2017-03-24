<?php

require('mysql.php');

$database = $_GET['database'];
$table = $_GET['table'];

// Determine what the fields are
$result = query($mysqli, "SHOW FIELDS FROM `" . escape($mysqli, $database) . "`.`" . escape($mysqli, $table) . "`;");
while($field = $result->fetch_assoc()) {
  $data['fields'][] = $field;
}

// Request data
$result = query($mysqli, "SELECT * FROM `" . escape($mysqli, $database) . "`.`" . escape($mysqli, $table) . "` LIMIT 30;");
while($row = $result->fetch_assoc()) {
  $data['data'][] = $row;
}

echo json_encode($data);

?>
