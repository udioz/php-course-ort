<?php
include_once "db.php";

$query = sprintf("delete from pets where id = %d",$_GET['pet_id']);
$res = $mysqli->query($query);

$mysqli->close();

if ($res) {	
	header("Location:pets?owner_id=".$_GET['owner_id']."&owner_name=".$_GET['owner_name']);
} else {
	echo 'Delete was unsuccessful';
}

?>