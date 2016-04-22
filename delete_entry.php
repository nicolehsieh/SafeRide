<?php

include('connectionData.php');

// Create connection
$sql_con = new mysqli($server, $username, $password, $dbname, $port);

// Check connection
if ($sql_con->connect_error) {
    die("Connection failed: ".$sql_con->connect_error);
} 

try{
	$id = $_GET['id'];

	$stmt = $sql_con->prepare("DELETE FROM schedules WHERE ID = ?");
	$stmt->bind_param("i", $id);
	$stmt->execute();

} catch(PDOException $e) {
    echo "Error: ".$e->getMessage();
}

?>