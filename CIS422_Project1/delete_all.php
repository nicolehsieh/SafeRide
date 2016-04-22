<?php

include('connectionData.php');

// Create connection
$sql_con = new mysqli($server, $username, $password, $dbname, $port);

// Check connection
if ($sql_con->connect_error) {
    die("Connection failed: ".$sql_con->connect_error);
} 


$stmt = $sql_con->prepare("DELETE FROM schedules;");
$stmt->execute();


?>