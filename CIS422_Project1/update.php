<?php
  //include connection file 
  include_once("connectionData.php");
  
  //define index of column
  $columns = array(
    0 =>'id', 
    1 => 'name',
    2 => 'uoid', 
    3 => 'email', 
    4 => 'phone', 
    5 => 'pickup_time', 
    6 => 'party', 
    7 => 'pickup', 
    8 => 'dropoff', 
    9 => 'comments', 
    10 => 'vehicle_no'
    
  );
  $error = true;
  $colVal = '';
  $colIndex = $rowId = 0;
  
  $msg = array('status' => !$error, 'msg' => 'Failed! updation in mysql');

  if(isset($_POST)){
    if(isset($_POST['val']) && !empty($_POST['val']) && $error) {
      $colVal = $_POST['val'];
      $error = false;
      
    } else {
      $error = true;
    }
    if(isset($_POST['index']) && $_POST['index'] >= 0 &&  $error) {
      $colIndex = $_POST['index'];
      $error = false;
    } else {
      $error = true;
    }
    if(isset($_POST['id']) && $_POST['id'] > 0 && $error) {
      $rowId = $_POST['id'];
      $error = false;
    } else {
      $error = true;
    }
  
    if(!$error) {
        $sql = "UPDATE schedules SET ".$columns[$colIndex]." = '".$colVal."' WHERE id='".$rowId."'";
        //$status = mysqli_query($sql_con, $sql) or die("database error:". mysqli_error($sql_con));
        $msg = array('status' => !$error, 'msg' => 'Success! updation in mysql');
    }
  }
  
  // send data as json format
  echo json_encode($msg);
  
?>
