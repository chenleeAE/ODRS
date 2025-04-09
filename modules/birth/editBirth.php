<?php
session_start();
require_once('../modules/database.php'); // Ensure this is included for DB connection

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch data from the form
    $request_id = mysqli_real_escape_string($connection, $_POST['request_id']);
    $request_for = mysqli_real_escape_string($connection, $_POST['request_for']);
    $number_of_copies = mysqli_real_escape_string($connection, $_POST['number_of_copies']);
    $brn = mysqli_real_escape_string($connection, $_POST['brn']);
    $sex = mysqli_real_escape_string($connection, $_POST['sex']);

    // Sanitize input further to prevent SQL Injection
    $request_for = htmlspecialchars($request_for);
    $number_of_copies = (int) $number_of_copies;
    $brn = htmlspecialchars($brn);
    $sex = htmlspecialchars($sex);

    // Check if all required fields are filled
    if (!empty($request_for) && !empty($number_of_copies) && !empty($sex)) {
        // Prepare the update query
        $update_query = "UPDATE request_type SET 
                            request_for = '$request_for', 
                            number_of_copies = '$number_of_copies', 
                            brn = '$brn', 
                            sex = '$sex' 
                         WHERE id = '$request_id'";

        // Execute the update query
        if (mysqli_query($connection, $update_query)) {
            // Redirect or show success message
            $_SESSION['success_message'] = 'Birth Certificate request updated successfully!';
            header("Location: dashboard.php"); // Redirect to dashboard or appropriate page
            exit();
        } else {
            // Error handling if the update fails
            $_SESSION['error_message'] = 'Failed to update the request. Please try again.';
            header("Location: dashboard.php");
            exit();
        }
    } else {
        // Handle missing form fields
        $_SESSION['error_message'] = 'Please fill in all required fields.';
        header("Location: dashboard.php");
        exit();
    }
} else {
    // If accessed without POST, redirect or show error
    $_SESSION['error_message'] = 'Invalid request method.';
    header("Location: dashboard.php");
    exit();
}
?>