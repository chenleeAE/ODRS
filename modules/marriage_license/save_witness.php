<?php
	require_once('../database.php');
    include '../helper.php';
	session_start();
	$session_id = $_SESSION["id"];
	$session_name = $_SESSION["first_name"] . ' ' . $_SESSION["last_name"];

	// Check if form is submitted
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Sanitize and retrieve form data
		$license_id = $_POST['license_id'];
		$witness_names = $_POST['witness_names'];
		$residency = $_POST['residency'];
		$name = $_POST['name'];
		$civil_status = $_POST['civil_status'];
		$to_marry = $_POST['to_marry'];
		$id_no = $_POST['id_no'];
		$date_issued = $_POST['date_issued'];
		$issued_at = $_POST['issued_at'];

		// Prepare the SQL query with placeholders
		$sql = "INSERT INTO `witness` (license_id, witness_names, residency, `name`, civil_status, to_marry, id_no, date_issued, issued_at, approved_by_id, approved_by, approved_by_date) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

		// Prepare the statement
		if ($stmt = $connection->prepare($sql)) {
			// Bind the parameters to the prepared statement
			$stmt->bind_param("sssssssssss", $license_id, $witness_names, $residency, $name, $civil_status, $to_marry, $id_no, $date_issued, $issued_at, $session_id, $session_name);
			
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
