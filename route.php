<?php


  include 'managers.php';
  $managerObj = new Employee();

   if(isset($_GET['id'])) {
    $managerObj->updateRecord($_POST);
   }

   if(isset($_POST['name'])) {
  
   $managerObj->insertData($_POST);
    
   }

?>