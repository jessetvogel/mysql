<?php

$host = '127.0.0.1';
$username = 'root';
$password = 'wachtwoord';
$database = 'database';

$mysqli = connect($host, $username, $password);

/* ------------------------------------------------------------------------ */
function connect($host, $username, $password) {
  $mysqli = new mysqli($host, $username, $password);
  if ($mysqli->connect_errno) {
      echo "Error: could not connect to " . $host . ".\n";
      echo "Errno: " . $mysqli->connect_errno . "\n";
      echo "Error: " . $mysqli->connect_error . "\n";
      exit;
  }
  return $mysqli;
}

function query($mysqli, $sql) {
  $result = $mysqli->query($sql);
  if (!$result) {
    echo "Error: query failed.\n";
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $mysqli->errno . "\n";
    echo "Error: " . $mysqli->error . "\n";
    exit;
  }
  return $result;
}

function escape($mysqli, $string) {
  return $mysqli->real_escape_string($string);
}

function databases($mysqli) {
  $sql = "SHOW DATABASES";
  $result = query($mysqli, $sql);
  $databases = [];
  while($data = $result->fetch_assoc()) {
    $databases[] = $data["Database"];
  }
  return $databases;
}

function tables($mysqli, $database) {
  $sql = "SHOW TABLES FROM " . escape($mysqli, $database) . ";";
  $result = query($mysqli, $sql);
  $tables = [];
  while($data = $result->fetch_assoc()) {
    $tables[] = $data["Tables_in_" . $database];
  }
  return $tables;
}

?>
