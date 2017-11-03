<?php
require_once "classes/owner.php";
include_once "init.php";

$owner = new Owner();
$owners = $owner->getlist();

// $query = "select *,(select count(*) from pets where owner_id=o.id) as pets_count
// 		  from owners as o";
// $selectResult = $mysqli->query($query);
?>

<table id="ownersListTable">
	<tr style="font-weight:bold;">
		<td>First Name</td>
		<td>Last Name</td>
		<td>Email</td>
		<td>Phone Number</td>
		<td>Pets Count</td>
	</tr>

<?php
	if ($owners) {
		$bgColor = "fff";
		foreach ($owners as $owner) {
			//($bgColor == "fff") ? $bgColor = "33ffdd" : $bgColor = "fff";
		?>
		<!-- <tr style="background-color:<?php //echo $bgColor ?>;"> -->
		<tr>
			<td><?php echo $owner->first_name ?></td>
			<td><?php echo $owner->last_name ?></td>
			<td><?php echo $owner->email ?></td>
			<td><?php echo $owner->phone_number ?></td>
			<td><?php echo $owner->pets_count ?></td>
			<td><a href="pets.php?owner_id=<?php echo $owner->id?>&owner_name=<?php echo urlencode($owner->first_name . " " . $owner->last_name)?>">Add a Pet</a></td>
			<td><input type="button" onclick="deleteOwner(<?php echo $owner->id?>)" value="Delete Owner"/></td>
		</tr>
	<?php } ?>
<?php } else { ?>
			<tr>
				<td colspan="3">No Owners Yet....</td>
			</tr>
		<?php } ?>
</table>
<script>
	$("#ownersListTable > tbody > tr:even").css({backgroundColor:'33ffdd'})
</script>
