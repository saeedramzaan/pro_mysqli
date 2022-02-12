<?php
  
  // Include database file
  include 'managers.php';
  $managerObj = new Employee();
  // Edit customer record
  if(isset($_GET['editId']) && !empty($_GET['editId'])) {
    $editId = $_GET['editId'];
    $customer = $managerObj->displyaRecordById($editId);
  }
  // Update Record in customer table
  if(isset($_POST['update'])) {
    $managerObj->updateRecord($_POST);
  }  
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sale Team App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
</head>
<body>
<div class="card text-center" style="padding:15px;">
  <h4>Sales Team App</h4>
</div><br> 
<div class="container">
    <div class="row">
        <div class="col-md-5 mx-auto">
            <div class="card">
                <div class="card-header bg-primary">
                    <h4 class="text-white">Update Records</h4>
                </div>
                <div class="card-body bg-light">
                  <form action="edit.php" method="POST">
                    <div class="form-group">
                      <label for="name">Name:</label>
                      <input type="text" class="form-control" name="uname" value="<?php echo $customer['name']; ?>" required="">
                    </div>
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" name="uemail" value="<?php echo $customer['email']; ?>" required="">
                    </div>
                    <div class="form-group">
                      <label for="Tele">Tele Phone</label>
                      <input type="text" class="form-control" name="tel_no" placeholder="Enter TelePhone No" value="<?php echo $customer['tel_no']; ?>"   required="">
                    </div>
                    <div class="form-group">
                      <label for="join_date">Joined Date</label>
                      <input type="date" class="form-control" name="join_date" placeholder="Enter Joined Date" value="<?php echo $customer['join_date']; ?>" required="">
                    </div>
                    <div class="form-group">
                      <label for="current_routes">Current Routes</label>
                      <input type="text" class="form-control" name="current_routes" placeholder="Enter current routes" value="<?php echo $customer['current_routes']; ?>" required="">
                    </div>
                    <div class="form-group">
                    <label for="manager_comment" >Manager Comment</label>
                     <textarea name="manager_comment"  id="inputPane" style="width:300px; text-align:top left; align-content:left; overflow:auto;">
                     <textarea name="manager_comment"  id="inputPane" style="width:300px; text-align:top left; align-content:left; overflow:auto;">
                     <?php echo $customer['manager_comment']; ?></textarea> 
                    <div>
                    <div class="form-group">
                      <input type="hidden" name="id" value="<?php echo $customer['id']; ?>">
                      <input type="submit" name="update" class="btn btn-primary" style="float:right;" value="Update">
                    </div>
                  </form>
                </div>
                </div>
            </div>
        </div>
    </div>
<script >
jQuery(function(​$) {
    var info = $('#name').val().trim();
    var pane = $('#inputPane');
    pane.val($.trim(pane.val()).replace(/\s*[\r\n]+\s*/g, '\n')
                               .replace(/(<[^\/][^>]*>)\s*/g, '$1')
                               .replace(/\s*(<\/[^>]+>)/g, '$1'));
});​

</script> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>