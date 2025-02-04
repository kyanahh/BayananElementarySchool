<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['Id'])) {
    $id = $_POST['Id'];

    $deleteQuery = "DELETE FROM events WHERE id = '$id'";
    $deleteResult = $connection->query($deleteQuery);

    if ($deleteResult) {
        echo json_encode(array('success' => 'Announcement deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Error deleting Announcement: ' . $connection->error));
    }

} else {
    echo json_encode(array('error' => 'Invalid request'));
}

$connection->close();

?>
