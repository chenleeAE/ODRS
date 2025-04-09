<?php

    require_once ('../database.php');  

    $id = mysqli_real_escape_string($connection,$_GET['id']);
    $license_id = mysqli_real_escape_string($connection,$_GET['license_id']);

    $query = "SELECT * FROM consents WHERE license_id = '$license_id' AND bride_id = '$id';";
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die('Query Failed'. mysqli_error($connection));
    }

    $json = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $json[] = $row;
    }
    // Convert to JSON and output
    echo json_encode($json);
?>
