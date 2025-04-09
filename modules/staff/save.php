<?php
    require_once('../database.php');
    include '../helper.php';
    session_start();

    try {
        // Sanitize and get POST values
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $status = $_POST['status'];
        $session_id = $_SESSION["id"];

        // Default password
        $password = '123456'; 
        $user_type = 'Staff'; 

        // Hash the password using PASSWORD_BCRYPT (recommended for hashing passwords)
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Prepare the SQL query
        $stmt1 = $connection->prepare("INSERT INTO users (`first_name`, `last_name`, `username`, `password`, `user_type`, `status`, `date_created`) VALUES (?, ?, ?, ?, ?, ?, NOW())");

        // Bind the parameters (note: we now bind variables, not hardcoded strings)
        $stmt1->bind_param("ssssss", $first_name, $last_name, $username, $hashed_password, $user_type, $status);

        // Execute the first query (insert into users)
        if ($stmt1->execute()) {
            // Get the last inserted user ID to log the activity
            $last_user_id = $stmt1->insert_id;

            // Prepare the second query to log the action
            $stmt2 = $connection->prepare("INSERT INTO logs (`user_id`, `logs_detail`, date_created) VALUES (?, CONCAT('Added User # ', ?), NOW())");
            $stmt2->bind_param("ii", $session_id, $last_user_id); // Bind correct parameters

            // Execute the second query (insert into logs)
            if ($stmt2->execute()) {
                echo 'success';
            } else {
                throw new Exception('Failed to execute log query.');
            }

        } else {
            throw new Exception('Failed to execute user insert query.');
        }

    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    } finally {
        // Close the prepared statements
        if (isset($stmt1)) $stmt1->close();
        if (isset($stmt2)) $stmt2->close();
    }
?>
