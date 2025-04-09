<?php
	require_once('../database.php');
    include '../helper.php';
	session_start();

	try {
		// Sanitize and get POST values
		// $client_id = $_POST['client_id'];
		$client_name = $_POST['client_name'];
		$received_by = $_POST['received_by'];

		$session_id = $_SESSION["id"];
		$session_name = $_SESSION["first_name"] . ' ' . $_SESSION["last_name"];

		// $stmt1 = $connection->prepare("INSERT INTO request_type 
		// 								SET `document_type` = 'Marriage License', 
		// 									`date_requested` = NOW(), 
		// 									`requested_by_id` = ?, 
		// 									`requested_by` = ?,
		// 									`status` = 'FOR PROCESSING',
		// 									`date_created` = NOW()");
		// $stmt1->bind_param("is", $client_id, $client_name);
	
		$stmt2 = $connection->prepare("INSERT INTO marriage_license 
			SET `request_id` = LAST_INSERT_ID(), 
				`client_name` = ?, 
				`received_by` = ?, 
				`date_created` = NOW()");
		
		$stmt2->bind_param("ss", $client_name, $received_by);

		$stmt3 = $connection->prepare("INSERT INTO logs (`user_id`, `logs_detail`, date_created) 
			VALUES (?, CONCAT('Created Marraige License # ', LAST_INSERT_ID()), NOW())");
		$stmt3->bind_param("i", $session_id);

		// Execute the queries
		if ($stmt2->execute() && $stmt3->execute()) {
			echo 'success';
		} else {
			throw new Exception('Failed to execute queries.');
		}

	} catch (Exception $e) {
		echo 'Error: ' . $e->getMessage();
	} finally {
		// Close the prepared statements
		// if (isset($stmt1)) $stmt1->close();
		if (isset($stmt2)) $stmt2->close();
		if (isset($stmt3)) $stmt3->close();
	}
?>
