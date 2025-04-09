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

    // Check if the record exists in the advice table
    $check_sql = "SELECT * FROM advice WHERE license_id = ? AND bride_id IS NOT NULL";
    if (!$stmt_check = $connection->prepare($check_sql)) {
        exit("Error preparing check statement: " . $connection->error);
    }
    $stmt_check->bind_param("i", $license_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

	if ($result_check->num_rows === 0) {
		// Fetch bride details from the marriage_bride table first
		$get_bride_sql = "SELECT * FROM marriage_bride WHERE license_id = ?";
		if (!$stmt_bride = $connection->prepare($get_bride_sql)) {
			exit("Error preparing bride query: " . $connection->error);
		}
		$stmt_bride->bind_param("i", $license_id);
		$stmt_bride->execute();
		$result_bride = $stmt_bride->get_result();
	
		if ($result_bride->num_rows === 0) {
			exit("No related data found in Bride.");
		}
	
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
		if ($result_groom->num_rows > 0) {
			$groom_details = $result_groom->fetch_assoc();
		}
		// Fetch groom details
		if ($groom_details) {
			$groom_name = $groom_details['fname'] . ' ' . $groom_details['mname'] . ' ' . $groom_details['lname'];
		}
	
		// Fetch bride details
		$bride_details = $result_bride->fetch_assoc();
		$bride_id = $bride_details['id'];
		$father_name = $bride_details['father_name'];
		$mother_name = $bride_details['mother_name'];
		$person_consent = $bride_details['person_consent'];

		$bride_name = $bride_details['fname'] . ' ' . $bride_details['mname'] . ' ' . $bride_details['lname'];
		$sex = $bride_details['sex'];
		$residence = $bride_details['residence'];


		// Insert the new record into the advice table
		$sql = "INSERT INTO advice (license_id, bride_id, sex, place, `date`, advice_to, to_marry, prepared_by_id, prepared_by, prepared_by_date) 
					VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?, NOW())";

		if (!$stmt_insert = $connection->prepare($sql)) {
			exit("Error preparing insert statement: " . $connection->error);
		}
		// Insert for Father Name if it exists
		if ($father_name || $mother_name) {
			$stmt_insert->bind_param("iissssss", $license_id, $bride_id, $sex, $residence, $bride_name, $groom_name, $session_id, $session_name);
			if (!$stmt_insert->execute()) {
				exit("Error inserting father record: " . $stmt_insert->error);
			}
		}

		// Insert for Person Consent if it exists
		// if ($person_consent) {
		// 	$stmt_insert->bind_param("iissssssssss", $license_id, $groom_id, $person_consent, $person_residence, 
		// 							$person_relationship, $groom_name, $residence, $age, $bride_name, $bride_residence, $session_id, $session_name);
		// 	if (!$stmt_insert->execute()) {
		// 		exit("Error inserting person consent record: " . $stmt_insert->error);
		// 	}
		// }

		echo "success";

		// Close statements
		$stmt_check->close();
		$stmt_groom->close();
		$stmt_insert->close();
	}

?>
