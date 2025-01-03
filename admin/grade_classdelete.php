<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['classId'])) {
    $assignmentid = $_POST['classId'];

    $deleteQuery = "DELETE FROM class_section_assignments WHERE assignmentid = '$assignmentid'";
    $deleteResult = $connection->query($deleteQuery);

    if ($deleteResult) {
        echo json_encode(array('success' => 'Class assignment deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Error deleting class assignment: ' . $connection->error));
    }

} else {
    echo json_encode(array('error' => 'Invalid request'));
}

$connection->close();

?>
