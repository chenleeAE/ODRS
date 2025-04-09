<?php
    require_once('../database.php');
    include '../helper.php';
    session_start();

    try {
        // Sanitize and get POST values
        $id = $_POST['id']; // The ID of the user to update
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $status = $_POST['status'];
        $session_id = $_SESSION["id"];

        // Prepare the SQL query for updating the user (without user_type and password)
        $stmt1 = $connection->prepare("UPDATE users SET `first_name` = ?, `last_name` = ?, `username` = ?, `status` = ? WHERE `id` = ?");

        // Bind the parameters (no user_type and password)
        $stmt1->bind_param("ssssi", $first_name, $last_name, $username, $status, $id);

        // Execute the update query (update users table)
        if ($stmt1->execute()) {
            // Prepare the second query to log the action
            $stmt2 = $connection->prepare("INSERT INTO logs (`user_id`, `logs_detail`, date_created) VALUES (?, CONCAT('Updated User # ', ?), NOW())");
            $stmt2->bind_param("ii", $session_id, $id); // Bind correct parameters

            // Execute the second query (insert into logs)
            if ($stmt2->execute()) {
                echo 'success';
            } else {
                throw new Exception('Failed to execute log query.');
            }

        } else {
            throw new Exception('Failed to execute user update query.');
        }

    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    } finally {
        // Close the prepared statements
        if (isset($stmt1)) $stmt1->close();
        if (isset($stmt2)) $stmt2->close();
    }
?>
