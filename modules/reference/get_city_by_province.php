<?php

    require_once ('../database.php');

    $province_id = mysqli_real_escape_string($connection, $_GET['province_id']);

    $query = "SELECT city_code, city FROM ref_city WHERE province_code = '$province_id' ORDER BY city ASC"; 
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die('Query Failed'. mysqli_error($connection));
    }

    // Fetch all rows as an associative array
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Encode the result into a JSON string
    echo json_encode($rows);
?>