<?php
session_start();

require("../server/connection.php");

$query = "SELECT c.senderid, c.senderid, c.message, c.sent_at, u.firstname 
          FROM chat_messages c 
          JOIN users u ON c.senderid = u.userid
          ORDER BY c.sent_at ASC";
$result = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $class = ($_SESSION["userid"] == $row["senderid"]) ? "sent" : "received";
    echo "<div class='message $class'><strong>{$row['firstname']}: </strong> {$row['message']}
          <div class='timestamp'>" . date('h:i A', strtotime($row["sent_at"])) . "</div></div>";
}
?>
