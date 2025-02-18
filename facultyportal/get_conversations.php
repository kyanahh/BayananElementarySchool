<?php
require("../server/connection.php");

if (isset($_GET['adviser_id'])) {
    $adviser_id = $_GET['adviser_id'];

    // Retrieve distinct conversations where the adviser is involved
    $query = "SELECT c.conversation_id, c.student_id, s.firstname, s.lastname 
              FROM conversations c
              JOIN users s ON c.student_id = s.userid
              WHERE c.adviser_id = ?
              ORDER BY c.created_at DESC";
    
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $adviser_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $conversation_id = $row['conversation_id'];
        $student_id = $row['student_id'];
        $student_name = htmlspecialchars($row['firstname'] . " " . $row['lastname']);

        echo "<li class='list-group-item conversation-item d-flex' data-conversation-id='$conversation_id' style='cursor: pointer;'>
                <p>$student_name</p>
              </li>";
    }
}
?>