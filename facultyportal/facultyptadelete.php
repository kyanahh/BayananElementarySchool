<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['ptaId'])) {
    $ptaid = $_POST['ptaId'];

    $deleteQuery = "DELETE FROM pta WHERE ptaid = '$ptaid'";
    $deleteResult = $connection->query($deleteQuery);

    if ($deleteResult) {
        echo json_encode(array('success' => 'PTA Post deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Error deleting PTA Post: ' . $connection->error));
    }

} else {
    echo json_encode(array('error' => 'Invalid request'));
}

$connection->close();

?>
