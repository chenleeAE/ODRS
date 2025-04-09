<?php
    require_once('../database.php');  
    
    $id = mysqli_real_escape_string($connection, $_GET['id']);

    $query = "SELECT * FROM birth WHERE `request_id` = '$id'; ";
    
    $stmt = mysqli_prepare($connection, $query);

    if (!$stmt) {
        die('Query Failed: ' . mysqli_error($connection));
    }

    // Bind the parameter (assuming city_id is an integer; adjust type if needed)
    // mysqli_stmt_bind_param($stmt, 'isii', $user_in_charge, $category, $fromYear, $toYear);

    // Execute the query
    mysqli_stmt_execute($stmt);

    // Get the result
    $result = mysqli_stmt_get_result($stmt);

    // Fetch all rows as an associative array
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Encode the result into a JSON string
    echo json_encode($rows);

    // Close the statement
    mysqli_stmt_close($stmt);
?>
