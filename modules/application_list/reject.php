<?php
	require_once('../database.php');
	require_once('../../vendor/autoload.php');  // Email library
	require_once('../mailer.php');             // sendEmail() function
	session_start();

	try {
		// Sanitize and get POST values
		$id = mysqli_real_escape_string($connection, $_POST['id']);
		$email = mysqli_real_escape_string($connection, $_POST['email']);

		// Email subject and body for rejection
		$subject = 'Your Request Has Been Rejected';
		$body = '
		<html>
			<head>
				<style>
					body {
						font-family: Arial, sans-serif;
						color: #333;
						background-color: #f9f9f9;
						margin: 0;
						padding: 20px;
					}
					.container {
						background-color: #ffffff;
						padding: 20px;
						border-radius: 8px;
						box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
						max-width: 600px;
						margin: 0 auto;
					}
					.content {
						font-size: 16px;
						line-height: 1.6;
						color: #555;
					}
				</style>
			</head>
			<body>
				<div class="container">
					<div class="content">
						<p>Dear Client,</p>
						<p>We regret to inform you that your document request has been <strong>rejected</strong>.</p>
						<p>Please double-check the information or requirements you submitted and try again. If you have questions, feel free to contact our office for clarification.</p>
						<p>Thank you for understanding.</p>
						<p>Sincerely,</p>
						<p>Municipality of Nasipit</p>
					</div>
				</div>
			</body>
		</html>';

		// Send the rejection email
		if (sendEmail($email, $subject, $body)) {
			// Update status to 'REJECTED' only if email sends successfully
			$query = "UPDATE request_type SET status = 'ISSUES OCCURRED' WHERE id = ?";

			$stmt = mysqli_prepare($connection, $query);
			mysqli_stmt_bind_param($stmt, 'i', $id);
			mysqli_stmt_execute($stmt) or die(mysqli_error($connection));

			if (mysqli_stmt_affected_rows($stmt) > 0) {
				echo 'success';
			} else {
				echo 'Status updated, but not reflected in the database.';
			}

			mysqli_stmt_close($stmt);
		} else {
			echo 'Failed to send rejection email. Status not updated.';
		}
	} catch (Exception $e) {
		echo 'Error: ' . $e->getMessage();
	}
?>