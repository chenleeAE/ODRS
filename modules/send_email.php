<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('database.php');
require_once('../vendor/autoload.php');
require_once('mailer.php'); 



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $messageContent = $_POST['messageContent'];
    $subject = 'New Message from Civil Registry Office';
    $recipientEmail = filter_var($_POST['recipientEmail'], FILTER_SANITIZE_EMAIL);

    // Validate recipient email
    if (!filter_var($recipientEmail, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }
         
    $emailSent = sendEmail($recipientEmail, $subject, $messageContent);

    if ($emailSent) {
        // Send success response if email was sent
        echo "success";
    } else {
        // Send error response if email was not sent
        echo "error";
    }
}
?>
