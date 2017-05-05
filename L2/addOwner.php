<?php

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
	$dbParams = array (
	  'hostname' => 'localhost',
	  'username' => 'root',
	  'password' => 'shahim15',
	  'database' => 'php-course'
	);

	$mysqli = new mysqli($dbParams['hostname'], $dbParams['username'], $dbParams['password'], $dbParams['database']);
	if ($mysqli->connect_errno) {
		echo "Failed to connect to MySQL: " . $mysqli->connect_error;
	}	
	
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