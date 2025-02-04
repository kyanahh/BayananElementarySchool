<?php

require("../server/connection.php");

$query = "SELECT cm.message, cm.sent_at, u.firstname, u.usertypeid FROM chat_messages cm 
          JOIN users u ON cm.senderid = u.userid ORDER BY cm.sent_at ASC";
$result = mysqli_query($connection, $query);

$output = "";
while ($row = mysqli_fetch_assoc($result)) {
    $class = ($row["usertypeid"] == 4) ? "sent" : "received";
    $output .= "<div class='message $class'><strong>{$row['firstname']}:</strong> {$row['message']}<br><span class='timestamp'>{$row['sent_at']}</span></div>";
}

echo $output;
?>
