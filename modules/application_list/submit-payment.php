<?php
	require_once('../database.php');
    include '../helper.php';
	session_start();

	try {
		// Sanitize and get POST values
		$id = $_POST['id'];
		$session_id = $_SESSION["id"];

		$image_path = "";
		$imageaccept = ["jpg", "png", "jpeg"];
		$directory = "upload/payment";
	
		// Handle file upload if present
		if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
			$image_path = uploadFile('file', 'file', $imageaccept, $directory);
		}

		// Prepare the SQL query
		$stmt1 = $connection->prepare("UPDATE request_type SET `proof_payment` = ?, `status` = 'FOR VERIFICATION' WHERE `id` = ?");
		$stmt1->bind_param("si", $image_path, $id);

		$stmt2 = $connection->prepare("INSERT INTO logs (`user_id`, `logs_detail`, date_created) VALUES (?, CONCAT('Submit Payment for request # ', ?), NOW())");
		$stmt2->bind_param("ii", $session_id, $id);

		// Execute the queries
		if ($stmt1->execute() && $stmt2->execute()) {
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
	}
?>
