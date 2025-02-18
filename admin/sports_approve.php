<?php

require("../server/connection.php");

if (isset($_POST['Id'])) { // Update this to match the JavaScript request
    $id = $_POST['Id'];

    $id = $connection->real_escape_string($id);

    $updateQuery = "UPDATE membership SET stats = 'Approved' WHERE memid = '$id'";
    $updateResult = $connection->query($updateQuery);

    if ($updateResult) {
        echo json_encode(['success' => 'Sports membership approved successfully']);
    } else {
        error_log("Error: " . $connection->error);
        echo json_encode(['error' => 'Error approving the sports membership.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$connection->close();

?>
