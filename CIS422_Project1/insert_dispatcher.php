<?php

include('connectionData.php');

// Create connection
$sql_con = new mysqli($server, $username, $password, $dbname, $port);

// Check connection
if ($sql_con->connect_error) {
    die("Connection failed: ".$sql_con->connect_error);
} 
            
try {

    $full_name = $_POST['user_name'];
    $user_uoid = $_POST['user_uoid'];
    $user_email = $_POST['user_email'];
    $user_phone = $_POST['user_phone'];
    $user_time = implode(':', $_POST['user_time']);
    $party_number = $_POST['party_number'];
    $user_pickup = $_POST['user_pickup'];
    $user_dropoff = $_POST['user_dropoff'];
    $color = "green"; // TODO: fix that!!!!!!!!!
    $cur_timestamp = GETDATE();
    

    // prepared statements
    $stmt = $sql_con->prepare("INSERT INTO schedules (full_name, uoid, email, phone, pickup_time, party, pickup, dropoff, color) VALUES (?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssss", $full_name, $user_uoid, $user_email, $user_phone, $user_time, $party_number, $user_pickup, $user_dropoff,$color);
    $stmt->execute();

} catch(PDOException $e) {
    echo "Error: ".$e->getMessage();
}

if($_POST){
    echo '<script>window.location = "success.html";</script>';
}
?>