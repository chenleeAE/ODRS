<?php
	require_once('../database.php');
	require_once('../../vendor/autoload.php');  // Include the email library
	require_once('../mailer.php');  // Assuming this contains the sendEmail function
	session_start();

	try {
		// Sanitize and get POST values
		$id = mysqli_real_escape_string($connection, $_POST['id']);
		$email = mysqli_real_escape_string($connection, $_POST['email']); // Get the email passed via POST

		// Email subject and body for notifying that the documents are ready for claiming
		$subject = 'Your Documents are Ready for Claiming';
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
					.header {
						text-align: center;
						color: #4CAF50;
					}
					.content {
						font-size: 16px;
						line-height: 1.6;
						color: #555;
					}
					.footer {
						font-size: 14px;
						color: #999;
						text-align: center;
						margin-top: 20px;
					}
				</style>
			</head>
			<body>
				<div class="container">
					<div class="content">
						<p>Dear Client,</p>
						<p>We are pleased to inform you that your document request has been processed and is now ready for claiming.</p>
						<p>Please be advised that you need to claim your documents within 30 days upon receipt of this email. Failure to claim your documents within this period may result in the cancellation of your request.</p>
						<p>If you have any questions or need further assistance, feel free to reach out to us.</p>
						<p>Thank you for choosing our services.</p>
						<p>Best regards,</p>
						<p>Municipality of Nasipit</p>
					</div>
				</div>
			</body>
		</html>';

		// Send the email
		if (sendEmail($email, $subject, $body)) {
			// Proceed to update the status only if email is sent successfully
			$query = "UPDATE `request_type` SET `status` = 'FOR CLAIMING' WHERE id = ?";
			
			// Prepare the SQL query
			$stmt = mysqli_prepare($connection, $query);
			
			// Bind parameters: 'i' = integer
			mysqli_stmt_bind_param($stmt, 'i', $id);
			
			// Execute the prepared statement
			mysqli_stmt_execute($stmt) or die(mysqli_error($connection));
			
			// Check if the status update was successful
			if (mysqli_stmt_affected_rows($stmt) > 0) {
				echo 'success';
			} else {
				echo 'Status updated, but failed to reflect the changes in the database.';
			}

			// Close the prepared statement
			mysqli_stmt_close($stmt);
		} else {
			// If email sending fails, do not update the status
			echo 'Failed to send email, status update was not performed.';
		}
	} catch (Exception $e) {
		echo 'Error: ' . $e->getMessage();
	}
?>
