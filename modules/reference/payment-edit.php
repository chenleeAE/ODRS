<?php
	require_once('../database.php');
    include '../helper.php';
	session_start();

	try {
		// Sanitize and get POST values
		$id = $_POST['id'];  // Assuming you have an 'id' in your POST data for identifying the record to update
		$type = $_POST['type'];
		$account_name = $_POST['account_name'];
		$account_number = $_POST['account_number'];
		$price = $_POST['price'];
		$status = $_POST['status'];
		$session_id = $_SESSION["id"];

		$image_path = NULL;  // Default to NULL if no image is uploaded
		$imageaccept = ["jpg", "png", "jpeg"];
		$directory = "upload/payment_type";

		// Check if a new file is uploaded
		if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
			// If a new file is uploaded, process it and get the file path
			$image_path = uploadFile('file', 'file', $imageaccept, $directory);
		}

		// Prepare the UPDATE SQL query
		if ($image_path !== NULL) {
			// If a new image is uploaded, update the image path
			$stmt1 = $connection->prepare("UPDATE payment_type SET `type` = ?, `account_name` = ?, `account_number` = ?, `price` = ?, `picture` = ?, `status` = ? WHERE `id` = ?");
			$stmt1->bind_param("ssssssi", $type, $account_name, $account_number, $price, $image_path, $status, $id);
		} else {
			// If no new image is uploaded, don't update the picture column
			$stmt1 = $connection->prepare("UPDATE payment_type SET `type` = ?, `account_name` = ?, `account_number` = ?, `price` = ?, `status` = ? WHERE `id` = ?");
			$stmt1->bind_param("sssssi", $type, $account_name, $account_number, $price, $status, $id);
		}

		// Prepare the log insertion query
		$stmt2 = $connection->prepare("INSERT INTO logs (`user_id`, `logs_detail`, date_created) VALUES (?, CONCAT('Updated Payment Type # ', ?), NOW())");
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
