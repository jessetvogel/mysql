<?php

  require('php/mysql.php');

?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MySQL</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/script.js"></script>
  </head>
  <body>

    <div id="wrapper">

      <div id="sidebar">
        <span>MySQL</span>
        <div id="input_database_wrapper"><select class="form-control" id="input_database"></select></div>
        <div id="menu" class="nav nav-pills nav-stacked" role="tablist"></div>
      </div>

      <div id="content"></div>

    </div>

  </body>
</html>
