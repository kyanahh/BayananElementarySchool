<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['enrollmentId'])) {
    $enrollmentId = $connection->real_escape_string($_POST['enrollmentId']);

    // Debugging log
    error_log("Attempting to reject enrollment application with ID: " . $enrollmentId);

    $updateQuery = "UPDATE enrollment_applications SET application_status = 'Rejected' WHERE applicationid = '$enrollmentId'";
    $updateResult = $connection->query($updateQuery);

    if ($updateResult) {
        echo json_encode(array('success' => 'Enrollment application rejected successfully'));
    } else {
        // Log error
        error_log("Database Error: " . $connection->error);
        echo json_encode(array('error' => 'Error rejecting the enrollment application'));
    }
} else {
    error_log("Invalid Request: POST data missing or incorrect");
    echo json_encode(array('error' => 'Invalid request'));
}

$connection->close();
?>
