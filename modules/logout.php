<?php
	require_once('database.php');
	session_start();

	$id = $_SESSION["id"];

	// Prepare and execute the query
	if ($stmt = $connection->prepare("INSERT INTO logs (`user_id`, `logs_detail`, date_created) VALUES (?, 'Logged Out', NOW())")) {
		$stmt->bind_param("i", $id);
		$stmt->execute();
		$stmt->close();
	}

	session_destroy();
	echo '<script>window.location = "../index.php";</script>';
?>
