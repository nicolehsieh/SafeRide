<?php
/* Sources: 
*  http://stackoverflow.com/questions/9332238/updating-table-with-database-query-on-jquery-ajax-form-submit
*  https://davidwalsh.name/html-mysql-php
*  http://stackoverflow.com/questions/15318368/mysqli-or-die-does-it-have-to-die
*  http://phpflow.com/php/html5-inline-editing-php-mysql-jquery-ajax/
*  http://stackoverflow.com/questions/18753262/example-of-how-to-use-bind-result-vs-get-result
*  http://www.tutorialspoint.com/php/mysql_update_php.htm
*  http://www.9lessons.info/2011/03/live-table-edit-with-jquery-and-ajax.html
*  http://www.infotuts.com/ajax-table-add-edit-delete-rows-dynamically-jquery-php/
*  http://stackoverflow.com/questions/20136649/autorefreshing-updating-table-using-jquery-ajax-by-either-using-json-or-html-fil
*/

  //include connection file 
  
  include_once("connectionData.php");
  
  //define index of column
  $columns = array(
    0 =>'time_stamp', 
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
      //$msg = array('status' => !$error, 'msg' => '1000000000');
      $colVal = $_POST['val'];
      $error = false;
      
    }
    else {
      //$msg = array('status' => !$error, 'msg' => '2000000000');
      $error = true;
    }
    if(isset($_POST['index']) && $_POST['index'] >= 0 &&  $error) {
      //$msg = array('status' => !$error, 'msg' => '30000000000');
      $colIndex = $_POST['index'];
      $error = false;
    }
    else {
      //$msg = array('status' => !$error, 'msg' => '40000000000');
      $error = true;
    }
    if(isset($_POST['id']) && $_POST['id'] >= 0 && $error) {
      //$msg = array('status' => !$error, 'msg' => '50000000000');
      $rowId = $_POST['id'];
      $error = false;
    }
    else {
      //$msg = array('status' => !$error, 'msg' => '60000000000');
      $error = true;
    }
    if(!$error) {
        //$sql = $sql_con->prepare("UPDATE schedules SET ".$columns[$colIndex]." = '".$colVal."' WHERE id='".$rowId."'");
        $sql = "UPDATE schedules SET ".$columns[$colIndex]." = '".$colVal."' WHERE id='".$rowId."'";
        $status = mysqli_query($sql_con, $sql) or trigger_error($sql_con->error."[ $sql]");
        $msg = array('status' => !$error, 'msg' => 'Success! updation in mysql');
    }
  }
  
  // send data as json format
  echo json_encode($msg);
  
?>

