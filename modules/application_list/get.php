<?php
    require_once('../database.php');
	session_start();
    
    // Get and sanitize the input
    $document_type = $_GET['document_type'];
    $session_id = $_SESSION["id"];
    
    // Prepare and execute the query
    $query = "SELECT * FROM request_type WHERE document_type = ? AND requested_by_id = ?";
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, "si", $document_type, $session_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Fetch the results
        $json = [];
        while ($row = mysqli_fetch_array($result)) {
            $json[] = [
                'date_requested'   => $row['date_requested'],
                'requested_by'     => $row['requested_by'],
                'number_of_copies'           => $row['number_of_copies'],
                'total_price'            => $row['total_price'],
                'acted_by'         => $row['acted_by'] ?? '',
                'proof_payment'    => $row['proof_payment'],
                'official_receipt' => $row['official_receipt'] ?? '',
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
