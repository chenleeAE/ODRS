<?php
    require_once ('../database.php');  
    
    $query = "SELECT * FROM payment_type";
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die('Query Failed'. mysqli_error($connection));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'type'           => $row['type'],
            'account_name'   => $row['account_name'],
            'account_number' => $row['account_number'],
            'price'          => $row['price'],
            'picture'        => $row['picture'],
            'status'         => $row['status'],
            'id'             => $row['id']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
