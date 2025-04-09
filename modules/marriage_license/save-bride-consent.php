<?php
	require_once('../database.php');
	include '../helper.php';
	session_start();
	$session_id = $_SESSION["id"];
	$session_name = $_SESSION["first_name"] . ' ' . $_SESSION["last_name"];

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Sanitize and retrieve form data
		$id = $_POST['consent_id'] ?? null;  // Use null if 'id' is not set
		$license_id = $_POST['license_id'];
		$bride_id = $_POST['bride_id'];
		$parent_name = $_POST['parent_name'];
		$parent_address = $_POST['parent_address'];
		$relationship = $_POST['relationship'];
		$child_name = $_POST['child_name'];
		$child_address = $_POST['child_address'];
		$child_age = $_POST['child_age'];
		$to_marry = $_POST['to_marry'];
		$to_marry_address = $_POST['to_marry_address'];

		if ($id) {
			// Update the existing consent
			$sql = "UPDATE consents 
					SET license_id = ?, bride_id = ?, parent_name = ?, parent_address = ?, relationship = ?, 
						child_name = ?, child_address = ?, child_age = ?, to_marry = ?, to_marry_address = ?, 
						prepared_by_id = ?, prepared_by = ?, prepared_by_date = NOW() 
					WHERE id = ?";

			// Prepare the statement
			if ($stmt = $connection->prepare($sql)) {
				// Bind the parameters to the prepared statement
				$stmt->bind_param("iissssssssssi", $license_id, $bride_id, $parent_name, $parent_address, $relationship, 
								$child_name, $child_address, $child_age, $to_marry, $to_marry_address, 
								$session_id, $session_name, $id);

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
			// Insert new consent
			$sql = "INSERT INTO consents (license_id, bride_id, parent_name, parent_address, relationship, 
										child_name, child_address, child_age, to_marry, to_marry_address, 
										prepared_by_id, prepared_by, prepared_by_date) 
					VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

			// Prepare the statement
			if ($stmt = $connection->prepare($sql)) {
				// Bind the parameters to the prepared statement
				$stmt->bind_param("iissssssssss", $license_id, $bride_id, $parent_name, $parent_address, $relationship, 
								$child_name, $child_address, $child_age, $to_marry, $to_marry_address, 
								$session_id, $session_name);

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
