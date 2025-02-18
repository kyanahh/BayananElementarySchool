<?php

require("../server/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["conversation_id"]) && isset($_POST["message_text"])) {
    $conversation_id = $_POST["conversation_id"];
    $message_text = trim($_POST["message_text"]);

    if ($message_text !== "") {
        // Fetch student_id and adviser_id from the conversations table
        $query = "SELECT student_id, adviser_id FROM conversations WHERE conversation_id = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("i", $conversation_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $student_id = $row["student_id"];
            $adviser_id = $row["adviser_id"];

            // Insert chat message with student_id and adviser_id
            $insert_query = "INSERT INTO student_teacher_chat (conversation_id, student_id, adviser_id, message_text, sender, status, timestamp) 
                             VALUES (?, ?, ?, ?, 'adviser', 'Unread', NOW())";
            $stmt = $connection->prepare($insert_query);
            $stmt->bind_param("iiis", $conversation_id, $student_id, $adviser_id, $message_text);

            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "Message sent!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Database execution failed!"]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid conversation ID!"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Message cannot be empty!"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request!"]);
}

?>
