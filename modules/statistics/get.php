<?php
    require_once('../database.php');

    // Get and sanitize the input
    $document_type = $_GET['document_type'];

    // Initialize the query
    $query = "";

    if ($document_type == 'All') {
        // Query for all document types
        $query = "
            SELECT 
                (SELECT COUNT(id) FROM `request_type` WHERE document_type = 'Birth Certificate') AS `birth`,
                (SELECT COUNT(id) FROM `request_type` WHERE document_type = 'Death Certificate') AS `death`,
                (SELECT COUNT(id) FROM `request_type` WHERE document_type = 'CENOMAR') AS `cenomar`,
                (SELECT COUNT(id) FROM `request_type` WHERE document_type = 'Marriage Certificate') AS `marriage`,
                (SELECT COUNT(id) FROM `request_type` WHERE document_type = 'Marriage License') AS `marriage_license`;
        ";
    } else {
        // Query for a specific document type
        $query = "SELECT COUNT(id) AS `data` FROM `request_type` WHERE document_type = '$document_type';";
    }

    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Fetch the result
        if ($document_type == 'All') {
            $json = mysqli_fetch_assoc($result);

            // Create response array with the desired format
            $response = [
                [
                    'label' => 'Birth Certificate',
                    'data' => $json['birth'],
                    'color' => '#d3d3d3'
                ],
                [
                    'label' => 'Death Certificate',
                    'data' => $json['death'],
                    'color' => '#bababa'
                ],
                [
                    'label' => 'CENOMAR',
                    'data' => $json['cenomar'],
                    'color' => '#79d2c0'
                ],
                [
                    'label' => 'Marriage Certificate',
                    'data' => $json['marriage'],
                    'color' => '#1ab394'
                ],
                [
                    'label' => 'Marriage License',
                    'data' => $json['marriage_license'],
                    'color' => '#ff7f50' // You can choose a color here
                ]
            ];
        } else {
            // For specific document_type, fetch single result
            $json = mysqli_fetch_assoc($result);

            // Create a response with a single document type
            $response = [
                [
                    'label' => $document_type,
                    'data' => $json['data'],
                    'color' => '#ff7f50' // You can adjust color based on document type
                ]
            ];
        }

        echo json_encode($response); // Output the response in the required format
        mysqli_stmt_close($stmt); // Close the statement
    } else {
        die('Query Failed: ' . mysqli_error($connection));
    }
?>
