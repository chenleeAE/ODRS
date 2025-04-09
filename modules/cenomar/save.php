<?php
	require_once('../database.php');
    include '../helper.php';
	session_start();

	try {
		// Sanitize and get POST values
		$number_of_copies = $_POST['number_of_copies'];
		$brn = $_POST['brn'];
		$sex = $_POST['sex'];
		$lname = $_POST['lname'];
		$fname = $_POST['fname'];
		$mname = $_POST['mname'];
		$dob = $_POST['dob'];
		$pob_province = $_POST['pob_province'];
		$pob_city = $_POST['pob_city'];
		$pob_country = isset($_POST['pob_country']) ? $_POST['pob_country'] : null;
		$father_lname = $_POST['father_lname'];
		$father_fname = $_POST['father_fname'];
		$father_mname = $_POST['father_mname'];
		$mother_lname = $_POST['mother_lname'];
		$mother_fname = $_POST['mother_fname'];
		$mother_mname = $_POST['mother_mname'];

		$session_id = $_SESSION["id"];
		$session_name = $_SESSION["first_name"] . ' ' . $_SESSION["last_name"];

		// Default values for image paths
		$valid_id_path = "";
		$authorization_letter_path = "";
		$imageaccept = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'webp', 'pdf']; // Accept all file types

		// Directories for storing the uploaded files
		$valid_id_directory = "upload/valid_id";
		$authorization_letter_directory = "upload/auth_letter";
	
		// Handle file upload for valid ID
		if (isset($_FILES['valid_id']) && $_FILES['valid_id']['error'] === UPLOAD_ERR_OK) {
			$valid_id_path = uploadFile('valid_id', 'file', $imageaccept, $valid_id_directory);
		}

		// Handle file upload for authorization letter
		if (isset($_FILES['authorization_letter']) && $_FILES['authorization_letter']['error'] === UPLOAD_ERR_OK) {
			$authorization_letter_path = uploadFile('authorization_letter', 'file', $imageaccept, $authorization_letter_directory);
		}

		$stmt1 = $connection->prepare("INSERT INTO request_type 
										SET `document_type` = 'CENOMAR', 
											`date_requested` = NOW(), 
											`requested_by_id` = ?, 
											`requested_by` = ?, 
											`copies` = ?,
											`date_created` = NOW()");
		$stmt1->bind_param("isi", $session_id, $session_name, $number_of_copies);
	
		$stmt2 = $connection->prepare("INSERT INTO cenomar 
			SET `request_id` = LAST_INSERT_ID(), 
				`number_of_copies` = ?, 
				`brn` = ?, 
				`sex` = ?, 
				`lname` = ?, 
				`fname` = ?, 
				`mname` = ?, 
				`dob` = ?, 
				`pob_province` = ?, 
				`pob_city` = ?, 
				`pob_country` = ?, 
				`father_lname` = ?, 
				`father_fname` = ?, 
				`father_mname` = ?, 
				`mother_lname` = ?, 
				`mother_fname` = ?, 
				`mother_mname` = ?, 
				`valid_id` = ?, 
				`authorization_letter` = ?, 
				`date_created` = NOW()");
		
		$stmt2->bind_param("ssssssssssssssssss", $number_of_copies, $brn, $sex, $lname, $fname, 
			$mname, $dob, $pob_province, $pob_city, $pob_country, $father_lname, $father_fname, $father_mname, 
			$mother_lname, $mother_fname, $mother_mname, $valid_id_path, $authorization_letter_path);

		$stmt3 = $connection->prepare("INSERT INTO logs (`user_id`, `logs_detail`, date_created) 
			VALUES (?, CONCAT('Requested CENOMAR # ', LAST_INSERT_ID()), NOW())");
		$stmt3->bind_param("i", $session_id);

		// Execute the queries
		if ($stmt1->execute() && $stmt2->execute() && $stmt3->execute()) {
			echo 'success';
		} else {
			throw new Exception('Failed to execute queries.');
		}

	} catch (Exception $e) {
		echo 'Error: ' . $e->getMessage();
	} finally {
		// Close the prepared statements
		if (isset($stmt1)) $stmt1->close();
		if (isset($stmt2)) $stmt2->close();
		if (isset($stmt3)) $stmt3->close();
	}
?>
