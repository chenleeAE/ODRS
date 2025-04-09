<?php
    require_once('database.php');
    session_start();

    $username = $_GET["username"];
    $password = $_GET["password"];

    // Function to handle login logic for users and clients
    function loginUser($connection, $username, $password, $table) {
        $stmt = $connection->prepare("SELECT * FROM $table WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password']) && ($user['status'] === 'Active' || $table === 'clients')) {
                $_SESSION = array_merge($_SESSION, $user);
                $logStmt = $connection->prepare("INSERT INTO logs (`user_id`, `logs_detail`, date_created) VALUES (?, 'Logged In', NOW())");
                $logStmt->bind_param("i", $user['id']);
                $logStmt->execute();
                return ['status' => 'success', 'message' => 'Logged in successfully as ' . ($table === 'users' ? 'user' : 'client')];
            }
        }
        return null;
    }

    $response = loginUser($connection, $username, $password, 'users') ?? loginUser($connection, $username, $password, 'clients');

    if ($response) {
        echo json_encode($response);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Incorrect Username or Password!']);
    }

    $connection->close();
?>
