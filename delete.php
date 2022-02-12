<?php
  // Include database file
  include 'managers.php';
  $managerObj = new Employee();

    $managerObj->deleteRecord($_POST);
