<?php
    class Employee
    {
        private $servername = "localhost";
        private $username   = "root";
        private $password   = "mysql123";
        private $database   = "sales_team";
        public  $con;
        // Database Connection 
        public function __construct()
        {
            $this->con = new mysqli($this->servername, $this->username,$this->password,$this->database);
            if(mysqli_connect_error()) {
             trigger_error("Failed to connect to MySQL: " . mysqli_connect_error());
            }else{
            return $this->con;
            }
            
        }
        // Insert customer data into customer table
        public function insertData($post)
        {
            $name = $this->con->real_escape_string($_POST['name']);
            $email = $this->con->real_escape_string($_POST['description']);
           
            $query="INSERT INTO managers(name,email) VALUES('$name','$email')";
            $sql = $this->con->query($query);
            if ($sql==true) {
                header("Location:index.php?msg1=insert");
            }else{
                echo "Registration failed try again!";
            }
        }
        // Fetch customer records for show listing
        public function displayData()
        {
           //  echo "add";
            $query = "SELECT name,email FROM managers";
            $result = $this->con->query($query);
        if ($result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                   $data[] = $row;
                 //  var_dump($data);
            }

            print($data);

         //   return $data['result'];

          //  return json_encode(array($data['result']));
       
       
            // var_dump($data);
           // echo $data;

        //  echo $json = json_decode($data, true);
          //  $data['result'] = $arr_variable;
          //  return json_encode($data);
           // exit;
           // return json_encode(array($data));
           // return 123;
            }else{
             echo "No found records";
            }
        }
        public function junk($id) {
            $arr=array("value"=>"123","value1"=>"123");
            
            return json_encode($arr); 
          
          }

        // Fetch single data for edit from customer table
        public function displyaRecordById($id)
        {
           
            $query = "SELECT * FROM managers WHERE id = '$id'";
            $result = $this->con->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
            }else{
            echo "Record not found";
            }
        }

        
        // Update customer data into customer table
        public function updateRecord($postData)
        {
           // echo "test123";
            $name = $this->con->real_escape_string($_POST['name']);
            $email = $this->con->real_escape_string($_POST['description']);
          
     //   if (!empty($id) && !empty($postData)) {
            $query = "UPDATE managers SET name = '$name', email = '$email' WHERE id = '{$_GET['id']}'";
            $sql = $this->con->query($query);
            if ($sql==true) {
              //  header("Location:index.php?msg2=update");
            }else{
               // echo "Registration updated failed try again!";
          //  }
            }
            
        }
        // Delete customer data from customer table
        public function deleteRecord($id)
        {
            $query = "DELETE FROM managers WHERE id = '{$_GET['id']}'";
            $sql = $this->con->query($query);
        if ($sql==true) {
           // header("Location:index.php?msg3=delete");
        }else{
            echo "Record does not delete try again";
            }
        }
    }

  


   
?>