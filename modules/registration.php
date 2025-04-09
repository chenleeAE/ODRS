<?php
    require_once('database.php');
    require_once('../vendor/autoload.php');
    require_once('mailer.php');
    session_start();

    try {
        // Sanitize and get POST values
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $mobile = $_POST['mobile'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $username = $_POST['username'];

        $random_password = bin2hex(random_bytes(4));
        $hashed_password = password_hash($random_password, PASSWORD_DEFAULT);

        // Start a transaction
        $connection->begin_transaction();

        // Check if the email already exists
        $query = "SELECT * FROM clients WHERE `email` = ? AND `status` = 'Active'; ";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("s", $email);

        $stmt->execute();
        $result = $stmt->get_result();
        $counter = $result->num_rows;

        if ($counter > 0) {
            // Email already exists
            echo json_encode([
                'status' => 'error',
                'message' => 'Email already exists!'
            ]);
        } else {
            // Prepare the SQL query for inserting a new client
            $stmt1 = $connection->prepare("INSERT INTO clients (`first_name`, `last_name`, `mobile_number`, `email`, `address`, `username`, `password`, `date_created`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt1->bind_param("sssssss", $first_name, $last_name, $mobile, $email, $address, $username, $hashed_password);

            // Execute the query to insert the new client
            if ($stmt1->execute()) {
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
                                    <p>Thank you for registering with us! Your account has been successfully created. Below is your password for logging in to the system:</p>
                                    <p class="password">Your Password: ' . $random_password . '</p>
                                    <p>Please keep your password secure and do not share it with anyone. If you have any questions or need assistance, feel free to reach out to us.</p>
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
                    // Commit the transaction if email is successfully sent
                    $connection->commit();

                    echo json_encode([
                        'status' => 'success',
                        'message' => 'Registration successful! Email has been sent successfully! Your password has been sent to your email address. Please check your inbox (and spam folder, just in case). If you did not request a password, please disregard this email.'
                    ]);
                } else {
                    // Rollback the transaction if email sending fails
                    $connection->rollback();

                    echo json_encode([
                        'status' => 'error',
                        'message' => 'Failed to send email. Account not created.'
                    ]);
                }
            } else {
                throw new Exception('Failed to execute queries.');
            }
        }

    } catch (Exception $e) {
        // Rollback the transaction in case of any errors
        $connection->rollback();

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
