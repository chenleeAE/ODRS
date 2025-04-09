<?php
	define('BASE_DIR', '../../public');  // Define a base directory constant

    // Ensure you have a valid database connection before using this function.
    function log_action($user_id, $description, $connection) {
        // Prepare the SQL query to insert the log entry
        $query = "INSERT INTO logs (`user_id`, `logs_detail`, date_created) VALUES (?, ?, NOW())";
        
        // Prepare the statement
        $stmt = $connection->prepare($query);
        
        // Bind the parameters: user_id is an integer, description is a string
        $stmt->bind_param("is", $user_id, $description);
        
        // Execute the query
        $stmt->execute() or die($stmt->error);
        
        // Close the statement
        $stmt->close();
    }

	function uploadFile($fileKey, $prefix, $imageaccept, $directory) {
		if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['tmp_name'] != '') {
			// Get the file extension and make it lowercase for comparison
			$ext = strtolower(pathinfo($_FILES[$fileKey]["name"], PATHINFO_EXTENSION));

			// Check if the file extension is in the accepted formats
			if (in_array($ext, $imageaccept)) {
				// Create a unique file name for the uploaded file
				$file_path = '/' . $directory . '/' . uniqid($prefix . '_') . '.' . $ext;

				// Ensure the full directory path exists
				$fullDirPath = BASE_DIR . '/' . $directory;
				if (!file_exists($fullDirPath)) {
					mkdir($fullDirPath, 0777, true);  // Create the directory if it doesn't exist
				}

				// Move the uploaded file to the target directory
				$move = move_uploaded_file($_FILES[$fileKey]['tmp_name'], BASE_DIR . $file_path);

				// Check if the file move was successful
				if (!$move) {
					echo "Error moving the file!";
					exit();
				}
				return $file_path; // Return the file path if successful
			} else {
				echo "File not accepted! Allowed formats: " . implode(", ", $imageaccept);
				exit();
			}
		} else {
			echo "File not accepted! Allowed formats: " . implode(", ", $imageaccept);
			exit();
		}
	}

    
?>