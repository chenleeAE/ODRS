<?php
	define('BASE_DIR', '../../public');  // Define a base directory constant

	// Include the PHPMailer library (make sure you've already installed PHPMailer)
	// require '../vendor/autoload.php'; // If using Composer
	// OR include manually
	// require 'path/to/PHPMailer/src/Exception.php';
	// require 'path/to/PHPMailer/src/PHPMailer.php';
	// require 'path/to/PHPMailer/src/SMTP.php';

	// Use PHPMailer classes
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	/**
	 * Send email using PHPMailer with predefined SMTP settings
	 *
	 * @param string $toRecipient   Email address of the recipient
	 * @param string $subject       Subject of the email
	 * @param string $body          HTML body content of the email
	 * @param string $fromName      Sender's name
	 * @return bool                 Returns true if email sent successfully, false otherwise
	 */
	function sendEmail($toRecipient, $subject, $body, $fromName = 'Online Document Request System') {
		// Predefined static values for Gmail SMTP
		$smtpHost = 'smtp.gmail.com';        // SMTP server for Gmail
		$smtpUser = 'odrssmcc@gmail.com';  // Your Gmail address
		$smtpPassword = 'zighdjivlrolkiag'; // Your Gmail App Password (if 2FA is enabled)
		$fromEmail = 'odrssmcc@gmail.com'; // Sender's email address (same as your Gmail)

		// Create a new PHPMailer instance
		$mail = new PHPMailer(true);

		try {
			// Server settings
			$mail->isSMTP();                                 // Set mailer to use SMTP
			$mail->Host       = $smtpHost;                   // Set the SMTP server to send through
			$mail->SMTPAuth   = true;                        // Enable SMTP authentication
			$mail->Username   = $smtpUser;                   // SMTP username (your Gmail address)
			$mail->Password   = $smtpPassword;               // SMTP password (use App Password if 2FA)
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
			$mail->Port       = 587;                         // TCP port to connect to (587 for TLS)

			// Recipients
			$mail->setFrom($fromEmail, $fromName);           // Set the sender's email and name
			$mail->addAddress($toRecipient);                 // Add a recipient

			// Content
			$mail->isHTML(true);                             // Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $body;
			$mail->AltBody = strip_tags($body);              // Plain text for non-HTML email clients

			// Send the email
			return $mail->send();                            // Returns true if email is sent
		} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			return false;                                    // Returns false if the email failed to send
		}
	}
  
?>