<?php
    require_once('../database.php');
    
    // Get and sanitize the input
    $document_type = $_GET['document_type'];
    $status = $_GET['status'];
    
    // Prepare and execute the query
    $query = "SELECT rt.*, c.email FROM request_type rt
                JOIN clients c ON rt.requested_by_id = c.id
                WHERE document_type = ? AND rt.`status` = ?; ";
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, "ss", $document_type, $status);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Fetch the results
        $json = [];
        while ($row = mysqli_fetch_array($result)) {
            $json[] = [
                'date_requested'   => $row['date_requested'],
                'requested_by'     => $row['requested_by'],
                'total_price'            => $row['total_price'],
                'acted_by'         => $row['acted_by'] ?? '',
                'proof_payment'    => $row['proof_payment'],
                'official_receipt' => $row['official_receipt'] ?? '',
                'email'            => $row['email'],
                'status'           => $row['status'],
                'id'               => $row['id']
            ];
        }

        echo json_encode($json); // Output the result
        mysqli_stmt_close($stmt); // Close the statement
    } else {
        die('Query Failed: ' . mysqli_error($connection));
    }
?>
