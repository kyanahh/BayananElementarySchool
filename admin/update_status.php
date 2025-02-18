<?php
require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memid = $_POST['memid'];
    $status = $_POST['status'];

    // Ensure status is a valid option
    $validStatuses = ['Approved', 'Rejected', 'AW', 'Removed'];
    if (!in_array($status, $validStatuses)) {
        echo json_encode(array('error' => 'Invalid status selected!'));
        exit;
    }

    $sql = "UPDATE membership SET stats = ? WHERE memid = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("si", $status, $memid);

    if ($stmt->execute()) {
        echo json_encode(array('success' => 'Status updated successfully!'));
    } else {
        echo json_encode(array('error' => 'Error updating status: ' . $connection->error));
    }    

    $stmt->close();
    $connection->close();
}
?>
