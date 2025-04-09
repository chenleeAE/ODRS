<?php
    require_once('../database.php');
    include '../helper.php';
    
    session_start();
    $session_id = $_SESSION["id"];
    $session_name = $_SESSION["first_name"] . ' ' . $_SESSION["last_name"];

    // Validate and sanitize the license_id if necessary
    $license_id = $_GET['license_id'] ?? null;
    if (!$license_id) {
        exit('License ID is required');
    }

    // Check if the record exists in the consents table
    $check_sql = "SELECT * FROM consents WHERE license_id = ? AND groom_id IS NOT NULL";
    if (!$stmt_check = $connection->prepare($check_sql)) {
        exit("Error preparing check statement: " . $connection->error);
    }
    $stmt_check->bind_param("i", $license_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows === 0) {
		// Fetch groom details from the marriage_groom table
		$get_groom_sql = "SELECT * FROM marriage_groom WHERE license_id = ?";
		if (!$stmt_groom = $connection->prepare($get_groom_sql)) {
			exit("Error preparing groom query: " . $connection->error);
		}
		$stmt_groom->bind_param("i", $license_id);
		$stmt_groom->execute();
		$result_groom = $stmt_groom->get_result();

		if ($result_groom->num_rows === 0) {
			exit("No related data found in Groom.");
		}

		// Fetch bride details from the marriage_bride table
		$get_bride_sql = "SELECT * FROM marriage_bride WHERE license_id = ?";
		if (!$stmt_bride = $connection->prepare($get_bride_sql)) {
			exit("Error preparing bride query: " . $connection->error);
		}
		$stmt_bride->bind_param("i", $license_id);
		$stmt_bride->execute();
		$result_bride = $stmt_bride->get_result();

		$bride_details = null; // Default to null if no bride data is found
		if ($result_bride->num_rows === 0) {
			exit("No related data found in Groom.");
		}
		if ($result_bride->num_rows > 0) {
			$bride_details = $result_bride->fetch_assoc();
		}
		// Fetch bride details
		if ($bride_details) {
			$bride_name = $bride_details['fname'] . ' ' . $bride_details['mname'] . ' ' . $bride_details['lname'];
			$bride_residence = $bride_details['residence'];
		}

		// Fetch groom details
		$groom_details = $result_groom->fetch_assoc();
		$groom_id = $groom_details['id'];
		$father_name = $groom_details['father_name'];
		$father_residence = $groom_details['father_residence'];
		$mother_name = $groom_details['mother_name'];
		$mother_residence = $groom_details['mother_residence'];
		$person_consent = $groom_details['person_consent'];
		$person_relationship = $groom_details['person_relationship'];
		$person_residence = $groom_details['person_residence'];

		$groom_name = $groom_details['fname'] . ' ' . $groom_details['mname'] . ' ' . $groom_details['lname'];
		$age = $groom_details['age'];
		$residence = $groom_details['residence'];

		// Insert the new record into the consents table
		$sql = "INSERT INTO consents (license_id, groom_id, parent_name, parent_address, relationship, 
										child_name, child_address, child_age, to_marry, to_marry_address, 
										prepared_by_id, prepared_by, prepared_by_date) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

		if (!$stmt_insert = $connection->prepare($sql)) {
			exit("Error preparing insert statement: " . $connection->error);
		}
		// Insert for Father Name if it exists
		if ($father_name) {
			$relation = 'Father';
			$stmt_insert->bind_param("iissssssssss", $license_id, $groom_id, $father_name, $father_residence, $relation, $groom_name, 
									$residence, $age, $bride_name, $bride_residence, $session_id, $session_name);
			if (!$stmt_insert->execute()) {
				exit("Error inserting father record: " . $stmt_insert->error);
			}
		}

		// Insert for Mother Name if it exists
		if ($mother_name) {
			$relation = 'Mother';
			$stmt_insert->bind_param("iissssssssss", $license_id, $groom_id, $mother_name, $mother_residence, $relation, $groom_name, 
									$residence, $age, $bride_name, $bride_residence, $session_id, $session_name);
			if (!$stmt_insert->execute()) {
				exit("Error inserting mother record: " . $stmt_insert->error);
			}
		}

		// Insert for Person Consent if it exists
		if ($person_consent) {
			$stmt_insert->bind_param("iissssssssss", $license_id, $groom_id, $person_consent, $person_residence, 
									$person_relationship, $groom_name, $residence, $age, $bride_name, $bride_residence, $session_id, $session_name);
			if (!$stmt_insert->execute()) {
				exit("Error inserting person consent record: " . $stmt_insert->error);
			}
		}

		echo "success";

		// Close statements
		$stmt_check->close();
		$stmt_groom->close();
		$stmt_insert->close();
	}

?>
