<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['gradeId'])) {
    $id = $_POST['gradeId'];

    $deleteQuery = "DELETE FROM student_grade_levels WHERE id = '$id'";
    $deleteResult = $connection->query($deleteQuery);

    if ($deleteResult) {
        echo json_encode(array('success' => 'Grade assignment deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Error deleting grade assignment: ' . $connection->error));
    }

} else {
    echo json_encode(array('error' => 'Invalid request'));
}

$connection->close();

?>
