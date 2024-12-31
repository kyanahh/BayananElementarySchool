<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['schedid'])) {
    $schedid = $_POST['schedid'];

    $deleteQuery = "DELETE FROM appsched WHERE schedid = '$schedid'";
    $deleteResult = $connection->query($deleteQuery);

    if ($deleteResult) {
        echo json_encode(array('success' => 'Exam Schedule deleted successfully'));
    } else {
        echo json_encode(array('error' => 'Error deleting user: ' . $connection->error));
    }

} else {
    echo json_encode(array('error' => 'Invalid request'));
}

$connection->close();

?>
