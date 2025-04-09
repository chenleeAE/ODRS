<?php
	require_once('../database.php');
    include '../helper.php';
	session_start();
	$session_id = $_SESSION["id"];
	$session_name = $_SESSION["first_name"] . ' ' . $_SESSION["last_name"];

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Sanitize and retrieve form data
		$id = $_POST['advice_id'] ?? null;  // If 'advice_id' is not set, use null
		$license_id = $_POST['license_id'];
		$bride_id = $_POST['bride_id'];
		$sex = $_POST['sex'];
		$place = $_POST['place'];
		$date = $_POST['date'];
		$advice_to = $_POST['advice_to'];
		$to_marry = $_POST['to_marry'];

		if ($id) {
			// Update the existing record if 'id' is present
			$sql = "UPDATE advice 
					SET license_id = ?, bride_id = ?, sex = ?, place = ?, `date` = ?, advice_to = ?, to_marry = ?, 
					prepared_by_id = ?, prepared_by = ?, prepared_by_date = NOW() 
					WHERE id = ?";
	
			// Prepare the statement
			if ($stmt = $connection->prepare($sql)) {
				// Bind the parameters to the prepared statement
				$stmt->bind_param("iisssssssi", $license_id, $bride_id, $sex, $place, $date, $advice_to, $to_marry, $session_id, $session_name, $id);
				
				// Execute the statement
				if ($stmt->execute()) {
					echo "success";
				} else {
					echo "Error updating data: " . $stmt->error;
				}
	
				// Close the statement
				$stmt->close();
			} else {
				echo "Error preparing statement: " . $connection->error;
			}
		} else {
			// Insert a new record if no 'id' is present
			$sql = "INSERT INTO advice (license_id, bride_id, sex, place, `date`, advice_to, to_marry, prepared_by_id, prepared_by, prepared_by_date) 
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
	
			// Prepare the statement
			if ($stmt = $connection->prepare($sql)) {
				// Bind the parameters to the prepared statement
				$stmt->bind_param("iisssssss", $license_id, $bride_id, $sex, $place, $date, $advice_to, $to_marry, $session_id, $session_name);
				
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
	}

?>
