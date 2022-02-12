<?php

function showAll() {

  $con = new mysqli("localhost","root","mysql123","sales_team");

// Check connection
if ($con -> connect_errno) {
  echo "Failed to connect to MySQL: " . $con -> connect_error;
  exit();
}
  $query = mysqli_query($con, "select id,name,email from managers");

  if ($query->num_rows > 0) {
  $data = array();
  while ($row = $query->fetch_assoc()) {
         $data[] = $row;
       //  var_dump($data);
  }

  return json_encode($data); 
   // print_r($data);
  
  
  }else{
   echo "No found records";
  }

}

$error = mysqli_error($con);

print($error);

mysqli_close($con);
exit(showAll());

?>