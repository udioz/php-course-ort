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

?>