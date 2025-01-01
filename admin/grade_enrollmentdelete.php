<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['enrollmentId'])) {
    $applicationid = $_POST['enrollmentId'];

    $deleteQuery = "DELETE FROM enrollment_applications WHERE applicationid = '$applicationid'";
    $deleteResult = $connection->query($deleteQuery);

    if ($deleteResult) {
        echo json_encode(array('success' => 'Enrollment application deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Error deleting enrollment application: ' . $connection->error));
    }

} else {
    echo json_encode(array('error' => 'Invalid request'));
}

$connection->close();

?>
