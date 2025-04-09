<?php
    require_once('../database.php');
    session_start();

    // Get POST data
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $session_id = $_SESSION["id"];

    // Prepare and execute query to get the hashed password
    $stmt = $connection->prepare("SELECT `password` FROM clients WHERE id = ?");
    $stmt->bind_param("s", $session_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify if the old password matches the hashed password
    if (password_verify($old_password, $hashed_password)) {
        // Update password and log the action
        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update_stmt = $connection->prepare("UPDATE `clients` SET `password` = ? WHERE id = ?");
        $update_stmt->bind_param("ss", $hashed_new_password, $session_id);
        $update_stmt->execute();
        $update_stmt->close();

        $log_stmt = $connection->prepare("INSERT INTO logs (`user_id`, `logs_detail`, date_created) VALUES(?, 'Changed Password', NOW())");
        $log_stmt->bind_param("s", $session_id);
        $log_stmt->execute();
        $log_stmt->close();

        echo 'success';
    } else {
        echo 'Invalid old password!';
    }
?>
