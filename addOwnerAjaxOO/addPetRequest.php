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

?>