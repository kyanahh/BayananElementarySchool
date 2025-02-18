<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['Id'])) {
    $id = $_POST['Id'];

    $deleteQuery = "DELETE FROM inquiry WHERE inquiryid = '$id'";
    $deleteResult = $connection->query($deleteQuery);

    if ($deleteResult) {
        echo json_encode(array('success' => 'Inquiry deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Error deleting inquiry: ' . $connection->error));
    }

} else {
    echo json_encode(array('error' => 'Invalid request'));
}

$connection->close();

?>
