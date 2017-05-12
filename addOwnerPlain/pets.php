<?php
include_once "db.php";

if (isset($_POST) && !empty($_POST)){
	$validated = true;
	if (empty($_POST['name'])) {
		$errs[] = "Pet name is empty";
		$validated = false;
	}
	$dateParts = explode("-",$_POST['birth_date']);
	if (!checkdate($dateParts[1],$dateParts[0],$dateParts[2])) {
		$errs[] = "Birth date should be a date";
		$validated = false;
	}
	if(empty($_POST['animal_type'])) {
		$errs[] = "Animal Type is empty";
		$validated = false;
	}

	if ($validated){
		// insert line to db	
		
		$values = array($_POST['owner_id'], 
						$_POST['name'],
						$dateParts[2] . "-" . $dateParts[1] . "-" . $dateParts[0],
						$_POST['animal_type']);
		$query = vsprintf('insert into pets (owner_id,name,birth_date,animal_type) values ("%s","%s","%s","%s")',$values);
		$res = $mysqli->query($query);
		
		if ($res)
			echo "Pet Added<br/>";
		else
			echo "Pet not Added<br/>";
	}

	if (isset($errs)){
		foreach ($errs as $err){
			echo "$err <br/>";
		}
	}
}

$query = sprintf("select * from pets where owner_id = %d",$_REQUEST['owner_id']);
$selectResult = $mysqli->query($query);
?>
<html>
	<head>
		<script src="../js/jquery.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script>
			$( function() {
				$( "#birth_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
			} );
		</script>
	</head>
	<body>

		<table>
		<form action="" method="post">
		<input type="hidden" name="owner_id" value="<?php echo $_REQUEST['owner_id'] ?>">
		<input type="hidden" name="owner_name" value="<?php echo $_REQUEST['owner_name'] ?>">
		<tr>
			<td>Pet Name</td><td><input type="text" name="name"></td>
		</tr>
		<tr>
			<td>Birth Date</td><td><input type="text" name="birth_date" id="birth_date"></td>
		</tr>
		<tr>
			<td>Animal Type</td>
			<td>
				<select name="animal_type">
					<option value="Cat">Cat</option>
					<option value="Dog">Dog</option>
					<option value="Horse">Horse</option>
					<option value="Donkey">Donkey</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"><input type="submit" value="Add a Pet"></td>
		</tr>
		</form>
		</table>

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
		<br/>
		<a href="owners.php">Back to Owners</a>
	</body>
</html>
