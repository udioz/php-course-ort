<?php

?>
<html>
	<head>
		<script src="../js/jquery.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script>
			// Short hand for document ready. See Long hand below.
			$( function() {
				$( "#birth_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
			} );
			// $( document ).ready(function() {
				// $( "#birth_date" ).datepicker({ dateFormat: 'dd-mm-yy' });
			// });
		</script>
		
		<script>
			function loadPetsList( jQuery ) {
				// Fire off the request
				request = $.ajax({
					url: "petsListRequest.php",
					data: { 
						owner_id: <?php echo $_REQUEST['owner_id'] ?>,
						owner_name: '<?php echo $_REQUEST['owner_name'] ?>'
					 },
					type: "get"
				});
				
				// Callback handler that will be called on success
				request.done(function (response, textStatus, jqXHR){
					// Log a message to the console
					console.log("Hooray, it worked!");

					$("#petsDiv").html(response);
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
		
			$( document ).ready(loadPetsList);
		</script>
		
	</head>
	<body>
		<div id="responseDiv"></div>

		<table>
		<form action="" method="" id="addPetForm">
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

		<div id="petsDiv">
		</div>
		
		<br/>
		<a href="owners.php">Back to Owners</a>
		
			<script>
		$("#addPetForm").submit(function(event){

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
				url: "addPetRequest.php",
				type: "post",
				data: serializedData
			});

			// Callback handler that will be called on success
			request.done(function (response, textStatus, jqXHR){
				// Log a message to the console
				console.log("Hooray, it worked!");

				$("#responseDiv").html(response);
				
				loadPetsList();
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
