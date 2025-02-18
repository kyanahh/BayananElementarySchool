<?php
require("../server/connection.php");

if (isset($_GET['conversation_id'])) {
    $conversation_id = $_GET['conversation_id'];

    $query = "SELECT * FROM student_teacher_chat WHERE conversation_id = ? ORDER BY timestamp ASC";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $conversation_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $sender = $row['sender'];
        $message = htmlspecialchars($row['message_text']);
        $timestamp = date("M j, Y - g:i A", strtotime($row['timestamp']));

        if ($sender == 'student') {
            echo "
                <div class='d-flex justify-content-start mb-3'>
                    <div class='p-3 bg-light rounded shadow-sm' style='max-width: 75%; border-radius: 15px;'>
                        <strong class='text-primary'>Student:</strong><br>
                        <span>$message</span>
                        <div class='text-muted small mt-1'>$timestamp</div>
                    </div>
                </div>
            ";
        } else {
            echo "
                <div class='d-flex justify-content-end mb-3'>
                    <div class='p-3 bg-success text-white rounded shadow-sm' style='max-width: 75%; border-radius: 15px;'>
                        <strong>Faculty:</strong><br>
                        <span>$message</span>
                        <div class='text-light small mt-1'>$timestamp</div>
                    </div>
                </div>
            ";
        }
    }
}
?>
