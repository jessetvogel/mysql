<?php

$database = $_GET['database'];
$table = $_GET['table'];

if(!isset($_GET['amount_rows'])) $amount_rows = 32; else $amount_rows = intval($_GET['amount_rows']); // Default number of rows
if(!isset($_GET['offset'])) $offset = 0; else $offset = intval($_GET['offset']); // Default offset

require('mysql.php');

$mysqli = connect($host, $username, $password);

// Determine what the fields are
$result = query($mysqli, "SHOW FIELDS FROM `" . escape($mysqli, $database) . "`.`" . escape($mysqli, $table) . "`;");
while($field = $result->fetch_assoc()) {
  $data['fields'][] = $field;
}

// Determine the amount of entries
$result = query($mysqli, "SELECT COUNT(*) AS NUMROWS FROM `" . escape($mysqli, $database) . "`.`" . escape($mysqli, $table) . "`;");
if($r = $result->fetch_assoc()) {
  $data['numrows'] = $r['NUMROWS'];
}

// Request data
$result = query($mysqli, "SELECT * FROM `" . escape($mysqli, $database) . "`.`" . escape($mysqli, $table) . "` LIMIT " . $offset . ", " . $amount_rows . ";");
while($row = $result->fetch_assoc()) {
  $data['data'][] = $row;
}

echo json_encode($data);

?>
