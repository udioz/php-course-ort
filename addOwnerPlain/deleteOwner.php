<?php
include_once "db.php";

$mysqli->begin_transaction();

$query = sprintf("delete from pets where owner_id = %d",$_GET['owner_id']);
$res = $mysqli->query($query);

if ($res) {
	$query = sprintf("delete from owners where id = %d",$_GET['owner_id']);
	$res = $mysqli->query($query);
} else {
	echo 'Delete of pets was unsuccessful';
}

if ($res) {
	$mysqli->commit();
	$mysqli->close();
	header("Location:owners.php");
} else {
	echo 'Delete of owner was unsuccessful';
}
?>