<?php
require_once('database.php');
require_once('../vendor/autoload.php');
require_once('mailer.php');
session_start();

try {
    // Sanitize and get POST values
    $email = $_GET['email'];

    // Generate a random password
    $random_password = bin2hex(random_bytes(4));
    $hashed_password = password_hash($random_password, PASSWORD_DEFAULT);

    // Check if the email exists in the database
    $query = "SELECT * FROM clients WHERE `email` = ? AND `status` = 'Active';";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $email);

    $stmt->execute();
    $result = $stmt->get_result();
    $counter = $result->num_rows;

    if ($counter > 0) {
        // Email exists, update the password in the database
        $stmt1 = $connection->prepare("UPDATE clients SET `password` = ? WHERE `email` = ?");
        $stmt1->bind_param("ss", $hashed_password, $email);

        // Execute the query to update password
        if ($stmt1->execute()) {
            // Prepare email content
            $subject = 'Your New Password for Online Document Request System';
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
                            <div class="header">
                                <h2>Welcome to the Online Document Request System</h2>
                            </div>
                            <div class="content">
                                <p>Hello,</p>
                                <p>We have received a request to reset your password. Below is your new password for logging in to the system:</p>
                                <p class="password">Your New Password: ' . $random_password . '</p>
                                <p>Please keep your password secure and do not share it with anyone. If you did not request a password reset, please contact us immediately.</p>
                                <p>Best regards,</p>
                                <p>Municipality of Nasipit</p>
                            </div>
                            <div class="footer">
                                <p>If you did not request this, please disregard this email.</p>
                            </div>
                        </div>
                    </body>
                </html>';

            // Send the email
            if (sendEmail($email, $subject, $body)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'A new password has been sent to your email address. Please check your inbox (and spam folder, just in case).'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to send email.'
                ]);
            }
        } else {
            throw new Exception('Failed to update password.');
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email not found or account is inactive.'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage()
    ]);
} finally {
    // Close the prepared statements
    if (isset($stmt1)) $stmt1->close();
    if (isset($stmt)) $stmt->close();
}
?>
