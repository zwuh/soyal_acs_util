<?php
 if (!isset($db_ready))
 {
  try {
    $dblink = mysqli_init();
    $dblink->real_connect('localhost', 'testrun', 'testrun', 'acs');
  } catch (Exception $e) {
    die ('DB initialisation error');
  }
  $db_ready = true;
 }
?>
