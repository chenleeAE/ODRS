<?php
  require_once('../database.php');

  if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Get the current proof_payment filename from the database
    $query = "SELECT proof_payment FROM request_type WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $proof = $row['proof_payment'];

        // Check if file path is valid
        $filePath = '../public/upload/payment' . basename($proof); // Use basename for security

        error_log("Original proof path: " . $proof);
        error_log("Server document root: " . $_SERVER['DOCUMENT_ROOT']);
        error_log("Constructed file path: " . $filePath);
        error_log("File exists check: " . (file_exists($filePath) ? 'Yes' : 'No'));

        if (!empty($proof) && file_exists($filePath)) {
            unlink($filePath); // Delete the file
        }

        // Update the database: remove proof_payment and reset status
        $update = "UPDATE request_type SET proof_payment = NULL, status = 'FOR PAYMENT' WHERE id = ?";
        $stmt = $connection->prepare($update);
        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error_db_update';
        }
    } else {
        echo 'not_found';
    }
} else {
    echo 'no_id';
}
?>