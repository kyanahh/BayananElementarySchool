<?php

require("../server/connection.php");

if (isset($_POST['enrollmentId'])) { // Update this to match the JavaScript request
    $applicationid = $_POST['enrollmentId'];

    $applicationid = $connection->real_escape_string($applicationid);

    $updateQuery = "UPDATE enrollment_applications SET application_status = 'Approved' WHERE applicationid = '$applicationid'";
    $updateResult = $connection->query($updateQuery);

    if ($updateResult) {
        echo json_encode(['success' => 'Enrollment application approved successfully']);
    } else {
        error_log("Error: " . $connection->error);
        echo json_encode(['error' => 'Error approving the enrollment application.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$connection->close();

?>
