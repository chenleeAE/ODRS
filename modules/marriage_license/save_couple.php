<?php
    require_once('../database.php');
    include '../helper.php';
    session_start();

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Retrieve data from the form
        $id = $_POST['id'] ?? null;  // Get the ID if available (for update)
        $license_id = $_POST['license_id'];
        $type = $_POST['type'];
        $to_marry = $_POST['to_marry'];
        $fname = $_POST['fname'];
        $mname = $_POST['mname'];
        $lname = $_POST['lname'];
        $bday = $_POST['bday'];
        $sex = $_POST['sex'];
        $citizenship = $_POST['citizenship'];
        $pob_city = $_POST['pob_city'];
        $pob_province = $_POST['pob_province'];
        $pob_country = $_POST['pob_country'];
        $residence = $_POST['residence'];
        $religion = $_POST['religion'];
        $civil_status = $_POST['civil_status'];
        $previously_married = $_POST['previously_married'] ?: null;
        $place_dissolved = $_POST['place_dissolved'] ?: null;
        $date_dissolved = $_POST['date_dissolved'] ?: null;
        $degree = $_POST['degree'] ?: null;
        $father_name = $_POST['father_name'] ?: null;
        $father_citizenship = $_POST['father_citizenship'] ?: null;
        $father_residence = $_POST['father_residence'] ?: null;
        $mother_name = $_POST['mother_name'] ?: null;
        $mother_citizenship = $_POST['mother_citizenship'] ?: null;
        $mother_residence = $_POST['mother_residence'] ?: null;    
        $person_consent = $_POST['person_consent'] ?: null;        
        $person_relationship = $_POST['person_relationship'] ?: null;
        $person_citizenship = $_POST['person_citizenship'] ?: null;
        $person_residence = $_POST['person_residence'] ?: null;

        $province = isset($_POST['province']) && $_POST['province'] ? $_POST['province'] : null;
        $city = isset($_POST['city']) && $_POST['city'] ? $_POST['city'] : null;
        $date_receipt = isset($_POST['date_receipt']) && $_POST['date_receipt'] ? $_POST['date_receipt'] : null;

        $registry_no = isset($_POST['registry_no']) && $_POST['registry_no'] ? $_POST['registry_no'] : null;
        $license_no = isset($_POST['license_no']) && $_POST['license_no'] ? $_POST['license_no'] : null;
        $date_issuance = isset($_POST['date_issuance']) && $_POST['date_issuance'] ? $_POST['date_issuance'] : null;

        // Calculate age based on birthday (bday)
        $birthDate = new DateTime($bday);
        $today = new DateTime('today');
        $age = $birthDate->diff($today)->y;

        // Determine which table to insert or update data into based on 'type'
        if ($type == 'groom') {
            $table = 'marriage_groom';
        } else if ($type == 'bride') {
            $table = 'marriage_bride';
        } else {
            // Invalid type
            echo "Invalid type.";
            exit();
        }

        // If an ID exists, perform an update, otherwise insert new record
        if ($id) {
            // SQL query for UPDATE operation
            $sql = "UPDATE $table SET
                    license_id = ?, 
                    to_marry = ?, 
                    fname = ?, 
                    mname = ?, 
                    lname = ?, 
                    bday = ?, 
                    age = ?, 
                    sex = ?, 
                    citizenship = ?, 
                    pob_city = ?, 
                    pob_province = ?, 
                    pob_country = ?, 
                    residence = ?, 
                    religion = ?, 
                    civil_status = ?, 
                    previously_married = ?, 
                    place_dissolved = ?, 
                    date_dissolved = ?, 
                    degree = ?, 
                    father_name = ?, 
                    father_citizenship = ?, 
                    father_residence = ?, 
                    mother_name = ?, 
                    mother_citizenship = ?, 
                    mother_residence = ?, 
                    person_consent = ?, 
                    person_relationship = ?, 
                    person_citizenship = ?, 
                    person_residence = ? 
                    WHERE id = ?";

            // Prepare the statement for update
            if ($stmt = $connection->prepare($sql)) {

                // Bind parameters for the update query
				$stmt->bind_param("isssssissssssssssssssssssssssi", 
					$license_id, 
					$to_marry, 
					$fname, 
					$mname, 
					$lname, 
					$bday, 
					$age, 
					$sex, 
					$citizenship, 
					$pob_city, 
					$pob_province, 
					$pob_country, 
					$residence, 
					$religion, 
					$civil_status, 
					$previously_married, 
					$place_dissolved, 
					$date_dissolved, 
					$degree, 
					$father_name, 
					$father_citizenship, 
					$father_residence, 
					$mother_name, 
					$mother_citizenship, 
					$mother_residence, 
					$person_consent, 
					$person_relationship, 
					$person_citizenship, 
					$person_residence, 
					$id
				);
			

                // Execute the statement
                if ($stmt->execute()) {
                    // echo "success";
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            } else {
                echo "Error: " . $connection->error;
            }

        } else {
            // SQL query for INSERT operation
            $sql = "INSERT INTO $table 
                    SET 
                    license_id = ?, 
                    to_marry = ?, 
                    fname = ?, 
                    mname = ?, 
                    lname = ?, 
                    bday = ?, 
                    age = ?, 
                    sex = ?, 
                    citizenship = ?, 
                    pob_city = ?, 
                    pob_province = ?, 
                    pob_country = ?, 
                    residence = ?, 
                    religion = ?, 
                    civil_status = ?, 
                    previously_married = ?, 
                    place_dissolved = ?, 
                    date_dissolved = ?, 
                    degree = ?, 
                    father_name = ?, 
                    father_citizenship = ?, 
                    father_residence = ?, 
                    mother_name = ?, 
                    mother_citizenship = ?, 
                    mother_residence = ?, 
                    person_consent = ?, 
                    person_relationship = ?, 
                    person_citizenship = ?, 
                    person_residence = ?";

            // Prepare the statement for insert
            if ($stmt = $connection->prepare($sql)) {

                // Bind parameters for the insert query
                $stmt->bind_param("isssssissssssssssssssssssssss", 
                    $license_id, 
                    $to_marry, 
                    $fname, 
                    $mname, 
                    $lname, 
                    $bday, 
                    $age,  // Bind the age value here
                    $sex, 
                    $citizenship, 
                    $pob_city, 
                    $pob_province, 
                    $pob_country, 
                    $residence, 
                    $religion, 
                    $civil_status, 
                    $previously_married, 
                    $place_dissolved, 
                    $date_dissolved, 
                    $degree, 
                    $father_name, 
                    $father_citizenship, 
                    $father_residence, 
                    $mother_name, 
                    $mother_citizenship, 
                    $mother_residence, 
                    $person_consent, 
                    $person_relationship, 
					$person_citizenship, 
                    $person_residence
                );

                // Execute the statement
                if ($stmt->execute()) {
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            } else {
                echo "Error: " . $connection->error;
            }
        }
        
        // Determine which table to insert or update data into based on 'type'
        if ($type == 'groom') {
            $update_sql = "UPDATE marriage_license SET province = ?, city = ?, date_receipt = ? WHERE id = ?";
            $update_stmt = $connection->prepare($update_sql);
            $update_stmt->bind_param("sssi", $province, $city, $date_receipt, $license_id);
            $update_stmt->execute();
            $update_stmt->close();
        } else if ($type == 'bride') {
            $update_sql = "UPDATE marriage_license SET registry_no = ?, license_no = ?, date_issuance = ? WHERE id = ?";
            $update_stmt = $connection->prepare($update_sql);
            $update_stmt->bind_param("sssi", $registry_no, $license_no, $date_issuance, $license_id);
            $update_stmt->execute();
            $update_stmt->close();
        }
        echo "success";

    } else {
        echo "No form data submitted.";
    }

    // Close the connection
    $connection->close();
?>
