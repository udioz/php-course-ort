<?php
include_once "db.php";

if (isset($_POST) && !empty($_POST)){

	$validated = true;
	if (empty($_POST['first_name'])) {
		$errs[] = "First name is empty";
		$validated = false;
	}
	if (empty($_POST['last_name'])) {
		$errs[] = "Last name is empty";
		$validated = false;
	}
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$errs[] = "Email should be an email";
		$validated = false;
	}
	if(!preg_match("/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/", $_POST['phone_number'])) {
		$errs[] = "Phone number should look like this 000-000-0000";
		$validated = false;
	}

	if ($validated){
		// insert line to db	
		
		$values = array($_POST['first_name'], 
						$_POST['last_name'],
						$_POST['email'],
						$_POST['phone_number']);
		$query = vsprintf('insert into owners (first_name,last_name,email,phone_number) values ("%s","%s","%s","%s")',$values);
		$res = $mysqli->query($query);
		
		if ($res)
			echo "Owner Added<br/>";
		else
			echo "Owner not Added<br/>";
	}

	if (isset($errs)){
		foreach ($errs as $err){
			echo "$err <br/>";
		}
	}
}

$query = "select *,(select count(*) from pets where owner_id=o.id) as pets_count
		  from owners as o";
$selectResult = $mysqli->query($query);

?>




<table>
<form action="" method="post">
<tr>
	<td>First Name</td><td><input type="text" name="first_name"></td>
</tr>
<tr>
	<td>Last Name</td><td><input type="text" name="last_name"></td>
</tr>
<tr>
	<td>Email</td><td><input type="text" name="email"></td>
</tr>
<tr>
	<td>Phone Number</td><td><input type="text" name="phone_number"></td>
</tr>
<tr>
	<td colspan="2"><input type="submit" value="Add Owner"></td>
</tr>
</form>
</table>

<br/>

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
			<td><a href="deleteOwner.php?owner_id=<?php echo $row['id']?>&owner_name=<?php echo urlencode($row['first_name'] . " " . $row['last_name'])?>">Delete Owner</a></td>
		</tr>
	<?php } ?>
<?php } else { ?>
			<tr>
				<td colspan="3">No Owners Yet....</td>
			</tr>
		<?php } ?>
</table>
