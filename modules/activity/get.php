<?php
    require_once ('../database.php');  
    
    $query = "SELECT l.user_id, l.logs_detail, l.date_created, u.first_name, u.last_name FROM logs l
                JOIN users u ON u.id = l.user_id;";
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die('Query Failed'. mysqli_error($connection));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'user_id'       => $row['user_id'],
            'logs_detail'   => $row['logs_detail'],
            'date_created'  => $row['date_created'],
            'first_name'    => $row['first_name'],
            'last_name'     => $row['last_name']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
