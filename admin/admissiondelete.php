<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['addid'])) {
    $addid = $_POST['addid'];

    $deleteQuery = "DELETE FROM admission WHERE addid = '$addid'";
    $deleteResult = $connection->query($deleteQuery);

    if ($deleteResult) {
        echo json_encode(array('success' => 'User deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Error deleting user: ' . $connection->error));
    }

} else {
    echo json_encode(array('error' => 'Invalid request'));
}

$connection->close();

?>
