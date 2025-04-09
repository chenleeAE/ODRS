<?php
	require_once('../database.php');
    include '../helper.php';
	session_start();
	$session_id = $_SESSION["id"];
	$session_name = $_SESSION["first_name"] . ' ' . $_SESSION["last_name"];

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Sanitize and retrieve form data
		$license_id = $_POST['license_id'];
		$sex = $_POST['sex'];
		$place = $_POST['place'];
		$date = $_POST['date'];
		$advice_to = $_POST['advice_to'];
		$to_marry = $_POST['to_marry'];
	
		// Prepare the SQL query with placeholders
		$sql = "INSERT INTO advice (license_id, sex, place, `date`, advice_to, to_marry, prepared_by_id, prepared_by, prepared_by_date) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
	
		// Prepare the statement
		if ($stmt = $connection->prepare($sql)) {
			// Bind the parameters to the prepared statement
			$stmt->bind_param("ssssssss", $license_id, $sex, $place, $date, $advice_to, $to_marry, $session_id, $session_name);
			
			// Execute the statement
			if ($stmt->execute()) {
				echo "success";
			} else {
				echo "Error inserting data: " . $stmt->error;
			}
	
			// Close the statement
			$stmt->close();
		} else {
			echo "Error preparing statement: " . $connection->error;
		}
	}

?>
