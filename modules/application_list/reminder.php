<?php
	require_once('../database.php');
    require_once('../../vendor/autoload.php');
    require_once('../mailer.php');
	session_start();

	try {
		// Sanitize and get POST values
		$id = $_GET['id'];

        // Check if the username already exists
        $query = "SELECT email FROM `request_type` rt
                    JOIN clients c ON rt.requested_by_id = c.id
                    WHERE rt.id = ?; ";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $id);
    
        $stmt->execute();
        $result = $stmt->get_result();
        $counter = $result->num_rows;

        if ($counter > 0) {
            // Fetch the email from the result
            $row = $result->fetch_assoc();
            $email = $row['email'];

            $subject = 'Pending Payment Reminder';
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
                        .password {
                            font-weight: bold;
                            font-size: 18px;
                            color: #2d87f0;
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
                            <p>Hello,</p>
                            <p>This is a reminder to pay your pending document request. Please settle your payment as soon as possible to avoid any delays in processing your request. Thank you!</p>
                            <p>Best regards,</p>
                            <p>Municipality of Nasipit</p>
                        </div>
                    </div>
                </body>
            </html>';

            if (sendEmail($email, $subject, $body)) {
                echo 'Email has been sent successfully!';
            } else {
                echo 'Failed to send email.';
            }

        } else {
            echo "No result found for this id.";
        }

        $stmt->close();

	} catch (Exception $e) {
		echo 'Error: ' . $e->getMessage();
	} finally {
		// Close the prepared statements
		if (isset($stmt1)) $stmt1->close();
	}
?>
