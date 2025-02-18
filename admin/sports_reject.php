<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['Id'])) {
    $Id = $connection->real_escape_string($_POST['Id']);

    // Debugging log
    error_log("Attempting to reject sports membership with ID: " . $Id);

    $updateQuery = "UPDATE membership SET stats = 'Rejected' WHERE memid = '$Id'";
    $updateResult = $connection->query($updateQuery);

    if ($updateResult) {
        echo json_encode(array('success' => 'Sports membership rejected successfully'));
    } else {
        // Log error
        error_log("Database Error: " . $connection->error);
        echo json_encode(array('error' => 'Error rejecting the sports membership'));
    }
} else {
    error_log("Invalid Request: POST data missing or incorrect");
    echo json_encode(array('error' => 'Invalid request'));
}

$connection->close();
?>
