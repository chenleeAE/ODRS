<?php
	require_once('../database.php');
    include '../helper.php';
	session_start();

	try {
		// Sanitize and get POST values
		$type = $_POST['type'];
		$account_name = $_POST['account_name'];
		$account_number = $_POST['account_number'];
		$price = $_POST['price'];
		$status = $_POST['status'];
		$session_id = $_SESSION["id"];

		$image_path = "";
		$imageaccept = ["jpg", "png", "jpeg"];
		$directory = "upload/payment_type";
	
		// Handle file upload if present
		if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
			$image_path = uploadFile('file', 'file', $imageaccept, $directory);
		}

		// Prepare the SQL query
		$stmt1 = $connection->prepare("INSERT INTO payment_type (`type`, `account_name`, `account_number`, `price`, `picture`, `status`, `date_created`) VALUES (?, ?, ?, ?, ?, ?, NOW())");
		$stmt1->bind_param("ssssss", $type, $account_name, $account_number, $price, $image_path, $status);

		$stmt2 = $connection->prepare("INSERT INTO logs (`user_id`, `logs_detail`, date_created) VALUES (?, CONCAT('Added Payment Type # ', LAST_INSERT_ID()), NOW())");
		$stmt2->bind_param("i", $session_id);

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
