<?php

require('mysql.php');

$mysqli = connect($host, $username, $password);

echo json_encode(databases($mysqli));

?>
