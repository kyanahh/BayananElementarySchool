<?php
session_start();
require("../server/connection.php");

if (!isset($_SESSION["logged_in"])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$parentid = $_SESSION["userid"];
$message = isset($_POST["message"]) ? trim($_POST["message"]) : '';

if (empty($message)) {
    echo json_encode(["status" => "error", "message" => "Message cannot be empty"]);
    exit();
}

$message = mysqli_real_escape_string($connection, $message);

$query = "INSERT INTO chat_messages (senderid, message) VALUES ('$parentid', '$message')";
if (mysqli_query($connection, $query)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Database error: " . mysqli_error($connection)]);
}
exit();  // Ensure no extra output after JSON response

?>
