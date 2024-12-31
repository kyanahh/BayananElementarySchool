<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['section_id'])) {
    $section_id = $_POST['section_id'];

    $deleteQuery = "DELETE FROM class_sections WHERE section_id = '$section_id'";
    $deleteResult = $connection->query($deleteQuery);

    if ($deleteResult) {
        echo json_encode(array('success' => 'Class Section deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Error deleting user: ' . $connection->error));
    }

} else {
    echo json_encode(array('error' => 'Invalid request'));
}

$connection->close();

?>
