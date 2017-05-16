<?php
?>
<html>
<head>
	<script src="../js/jquery.js"></script>
	<script>
		function loadOwnersList( jQuery ) {
			// Fire off the request
			request = $.ajax({
				url: "ownersListRequest.php",
				type: "get"
			});
			
			// Callback handler that will be called on success
			request.done(function (response, textStatus, jqXHR){
				// Log a message to the console
				console.log("Hooray, it worked!");
				$("#ownersDiv").html(response);
			});

			// Callback handler that will be called on failure
			request.fail(function (jqXHR, textStatus, errorThrown){
				// Log the error to the console
				console.error(
					"The following error occurred: "+
					textStatus, errorThrown
				);
			});
		
		}
	
		$( document ).ready(loadOwnersList);
		
		function deleteOwner(ownerId){
			// Fire off the request to /form.php
			request = $.ajax({
				url: "deleteOwnerRequest.php",
				type: "post",
				data: {
					owner_id : ownerId
				}
			});

			// Callback handler that will be called on success
			request.done(function (response, textStatus, jqXHR){
				// Log a message to the console
				console.log("Hooray, it worked!");			
				loadOwnersList();
			});

			// Callback handler that will be called on failure
			request.fail(function (jqXHR, textStatus, errorThrown){
				// Log the error to the console
				console.error(
					"The following error occurred: "+
					textStatus, errorThrown
				);
			});

			
		}
	</script>
</head>
<body>
	<div id="responseDiv"></div>
	<table>
		<form id="addOwnerForm">
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
	
	<div id="ownersDiv">
	</div>
	
	<script>
		$("#addOwnerForm").submit(function(event){

			// Prevent default posting of form - put here to work in case of errors
			event.preventDefault();

			// setup some local variables
			var $form = $(this);

			// Let's select and cache all the fields
			var $inputs = $form.find("input, select, button, textarea");

			// Serialize the data in the form
			var serializedData = $form.serialize();

			// Let's disable the inputs for the duration of the Ajax request.
			// Note: we disable elements AFTER the form data has been serialized.
			// Disabled form elements will not be serialized.
			$inputs.prop("disabled", true);

			// Fire off the request to /form.php
			request = $.ajax({
				url: "addOwnerRequest.php",
				type: "post",
				data: serializedData
			});

			// Callback handler that will be called on success
			request.done(function (response, textStatus, jqXHR){
				// Log a message to the console
				console.log("Hooray, it worked!");
				$("#responseDiv").html(response);
				
				loadOwnersList();
			});

			// Callback handler that will be called on failure
			request.fail(function (jqXHR, textStatus, errorThrown){
				// Log the error to the console
				console.error(
					"The following error occurred: "+
					textStatus, errorThrown
				);
			});

			// Callback handler that will be called regardless
			// if the request failed or succeeded
			request.always(function () {
				// Reenable the inputs
				$inputs.prop("disabled", false);
			});

		});	
		
		
	</script>
	
</body>	
</html>
