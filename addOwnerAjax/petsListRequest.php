<?php
include_once "db.php";

$query = sprintf("select * from pets where owner_id = %d",$_REQUEST['owner_id']);
$selectResult = $mysqli->query($query);
?>


<br/>
<div style="font-weight:bold;">
	The Pets of <?php echo $_REQUEST['owner_name'] ?>
</div>
<br/>
<table>
	<tr style="font-weight:bold;">
		<td>Pet Name</td>
		<td>Birth Date</td>
		<td>Animal Type</td>
	</tr>

<?php 
	if ($selectResult->num_rows) {
		$bgColor = "fff";
		while ($row = $selectResult->fetch_assoc()) { 
			($bgColor == "fff") ? $bgColor = "33ffdd" : $bgColor = "fff";
		?>
		<tr style="background-color:<?php echo $bgColor ?>;">
			<td><?php echo $row['name'] ?></td>
			<td><?php echo $row['birth_date'] ?></td>
			<td><?php echo $row['animal_type'] ?></td>
			<td><a href="deletePet?pet_id=<?php echo $row['id'] ?>&owner_id=<?php echo $row['owner_id']?>&owner_name=<?php echo urlencode($_REQUEST['owner_name'])?>">Delete</a></td>
		</tr>
	<?php } ?>
<?php } else { ?>
		<tr>
			<td colspan="3">No Pets Yet....</td>
		</tr>
<?php } ?>
</table>
