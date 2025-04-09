<?php
    require_once('../database.php');
    require_once('../../vendor/autoload.php');
    require_once('../mailer.php');
    session_start();

    try {
        // Sanitize and get POST values
        $id = $_POST['id'];

        // Generate a random temporary password
        $random_password = bin2hex(random_bytes(4));
        $hashed_password = password_hash($random_password, PASSWORD_DEFAULT);

        // Check if the client exists and retrieve the email
        $query = "SELECT email FROM `clients` WHERE id = ?; ";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $id);

        $stmt->execute();
        $result = $stmt->get_result();
        $counter = $result->num_rows;

        if ($counter > 0) {
            // Fetch the email from the result
            $row = $result->fetch_assoc();
            $email = $row['email'];

            // Update the password in the database
            $updateQuery = "UPDATE `clients` SET `password` = ? WHERE id = ?";
            $updateStmt = $connection->prepare($updateQuery);
            $updateStmt->bind_param("ss", $hashed_password, $id);

            if ($updateStmt->execute()) {
                // Prepare email content
                $subject = 'Password Reset';
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
                                .footer a {
                                    color: #4CAF50;
                                    text-decoration: none;
                                }
                            </style>
                        </head>
                        <body>
                            <div class="container">
                                <div class="header">
                                    <h2>Password Reset Request</h2>
                                </div>
                                <div class="content">
                                    <p>Dear Customer,</p>
                                    <p>We have received a request to reset your password for your account. Please find the new temporary password below:</p>
                                    <p><strong>Your New Password: <span class="password">' . $random_password . '</span></strong></p>
                                    <p>Please note that for security reasons, we strongly advise you to change your password after logging in with the provided temporary password.</p>
                                    <p>If you did not request this password reset, please contact our support team immediately.</p>
                                    <p>Best regards,</p>
                                    <p><strong>Municipality of Nasipit</strong></p>
                                </div>
                                <div class="footer">
                                    <p>If you have any questions, feel free to <a href="mailto:support@nasipit.com">contact us</a>.</p>
                                </div>
                            </div>
                        </body>
                    </html>';

                // Send the email
                if (sendEmail($email, $subject, $body)) {
                    echo 'Email has been sent successfully!';
                } else {
                    echo 'Failed to send email.';
                }
            } else {
                echo 'Failed to update password.';
            }

            $updateStmt->close();
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
