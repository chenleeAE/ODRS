<?php
    require_once('../database.php');
    
    // Get and sanitize the input
    // Prepare and execute the query
    $query = "SELECT * FROM marriage_license; ";
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Fetch the results
        $json = [];
        while ($row = mysqli_fetch_array($result)) {
            $json[] = [
                'client_name'      => $row['client_name'],
                'received_by'      => $row['received_by'],
                'acted_by'         => $row['acted_by'] ?? '',
                'license_id'       => $row['id'],
                'license_no'       => $row['license_no']
            ];
        }

        echo json_encode($json); // Output the result
        mysqli_stmt_close($stmt); // Close the statement
    } else {
        die('Query Failed: ' . mysqli_error($connection));
    }
?>
