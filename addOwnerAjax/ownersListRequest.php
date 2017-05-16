<?php
include_once "db.php";

$query = "select *,(select count(*) from pets where owner_id=o.id) as pets_count
		  from owners as o";
$selectResult = $mysqli->query($query);
?>

<table>
	<tr style="font-weight:bold;">
		<td>First Name</td>
		<td>Last Name</td>
		<td>Email</td>
		<td>Phone Number</td>
		<td>Pets Count</td>
	</tr>

<?php 
	if ($selectResult) {
		$bgColor = "fff";
		while ($row = $selectResult->fetch_assoc()) { 
			($bgColor == "fff") ? $bgColor = "33ffdd" : $bgColor = "fff";
		?>
		<tr style="background-color:<?php echo $bgColor ?>;">
			<td><?php echo $row['first_name'] ?></td>
			<td><?php echo $row['last_name'] ?></td>
			<td><?php echo $row['email'] ?></td>
			<td><?php echo $row['phone_number'] ?></td>
			<td><?php echo $row['pets_count'] ?></td>
			<td><a href="pets.php?owner_id=<?php echo $row['id']?>&owner_name=<?php echo urlencode($row['first_name'] . " " . $row['last_name'])?>">Add a Pet</a></td>
			<td><input type="button" onclick="deleteOwner(<?php echo $row['id']?>)" value="Delete Owner"/></td>
		</tr>
	<?php } ?>
<?php } else { ?>
			<tr>
				<td colspan="3">No Owners Yet....</td>
			</tr>
		<?php } ?>
</table>