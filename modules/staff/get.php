<?php
    require_once ('../database.php'); 

    $status = $_GET['status'];
    
    $query = "SELECT * FROM users WHERE `user_type` = 'Staff' AND `status` = '$status'; ";
    $result = mysqli_query($connection, $query);
    
    if(!$result) {
        die('Query Failed'. mysqli_error($connection));
    }

    $json = array();
    while($row = mysqli_fetch_array($result)) {
        $json[] = array(
            'first_name'    => $row['first_name'],
            'last_name'     => $row['last_name'],
            'username'      => $row['username'],
            'password'      => $row['password'],
            'status'        => $row['status'],
            'id'            => $row['id']
        );
    }
    $jsonstring = json_encode($json);
    echo $jsonstring;
?>
