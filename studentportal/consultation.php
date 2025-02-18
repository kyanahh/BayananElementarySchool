<?php

session_start();
require("../server/connection.php");

if (isset($_SESSION["logged_in"])) {
    if (isset($_SESSION["firstname"]) || isset($_SESSION["email"])) {
        $textaccount = $_SESSION["firstname"];
        $userid = $_SESSION["userid"];
    } else {
        $textaccount = "Account";
    }
} else {
    $textaccount = "Account";
}

$student_id = $userid; // Assuming the session holds the student ID

// Get the student's assigned adviser
$stmt = $connection->prepare("SELECT class_sections.adviser AS adviser_id, users.firstname, users.lastname FROM class_sections INNER JOIN class_section_assignments ON class_section_assignments.sectionid = class_sections.section_id INNER JOIN enrollment_applications ON enrollment_applications.applicationid = class_section_assignments.applicationid LEFT JOIN users ON class_sections.adviser = users.userid WHERE enrollment_applications.studentid = ? LIMIT 1");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $adviser_id = $row["adviser_id"] ?? NULL;
    $adviser = trim(($row["firstname"] ?? "") . " " . ($row["lastname"] ?? "")) ?: "N/A";
} else {
    $errorMessage = "Adviser not found for this student.";
    $adviser_id = NULL;
}

// Check if a conversation already exists
$conversation_id = NULL;
$conv_stmt = $connection->prepare("SELECT conversation_id FROM conversations WHERE student_id = ? AND adviser_id = ? LIMIT 1");
$conv_stmt->bind_param("ii", $student_id, $adviser_id);
$conv_stmt->execute();
$conv_res = $conv_stmt->get_result();

if ($conv_res && $conv_res->num_rows > 0) {
    $conv_row = $conv_res->fetch_assoc();
    $conversation_id = $conv_row['conversation_id'];
} else {
    // Create new conversation if it doesn't exist
    $conv_insert = $connection->prepare("INSERT INTO conversations (student_id, adviser_id) VALUES (?, ?)");
    $conv_insert->bind_param("ii", $student_id, $adviser_id);
    if ($conv_insert->execute()) {
        $conversation_id = $conv_insert->insert_id;
    }
}

$message = "";
$toastMessage = "";
$toastType = "";
if (isset($_POST['send_message'])) {
    $message = $_POST['message_text'];

    if (!empty($message) && $adviser_id !== NULL) { // Ensure adviser_id is not null
        // Insert the message into the chat table
        $insert_query = "INSERT INTO student_teacher_chat (conversation_id, student_id, adviser_id, message_text) VALUES (?, ?, ?, ?)";
        $insert_stmt = $connection->prepare($insert_query);
        $insert_stmt->bind_param("iiis", $conversation_id, $student_id, $adviser_id, $message);
        if ($insert_stmt->execute()) {
        } else {
            $toastMessage = "Error sending message.";
            $toastType = "danger";
        }
    } else {
        $toastMessage = "Message cannot be empty or adviser is not assigned.";
        $toastType = "warning";
    }
}

// Fetch chat history
$chat_query = "SELECT sender, message_text, timestamp FROM student_teacher_chat WHERE conversation_id = ? ORDER BY timestamp DESC";
$chat_stmt = $connection->prepare($chat_query);
$chat_stmt->bind_param("i", $conversation_id);
$chat_stmt->execute();
$chat_result = $chat_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bayanan Elementary School - Main</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<style>
    .chat-box {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        max-height: 400px;
        overflow-y: scroll;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .message {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .message-bubble {
        padding: 10px 15px;
        border-radius: 20px;
        margin-bottom: 10px;
        max-width: 75%;
        background-color: #e9ecef;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .message-bubble.student-message {
        background-color: #d1e7dd;
        margin-left: auto;
        text-align: right;
    }

    .message-bubble.adviser-message {
        background-color: #f8d7da;
    }

    .message-bubble p {
        margin: 0;
    }

    .form-group textarea {
        border-radius: 8px;
        padding: 12px;
        border: 1px solid #ddd;
    }

    .btn-primary {
        border-radius: 8px;
    }

    .btn-primary:hover {
        background-color: #0069d9;
        border-color: #0062cc;
    }
</style>
<body style="background-color: #424d21;">
    <nav class="navbar" style="background-color: #708238;">
        <a class="navbar-brand" style="color: #708238;">Navbar</a>
          <div class="d-flex me-5">
            <a href="https://www.facebook.com/BESMainMuntinlupaOFFICIAL/" target="_blank">
                <i class="bi bi-facebook text-white"></i></a>
            <a href="mailto:bayanan.esmain2016@gmail.com"><i class="bi bi-google text-white ms-4"></i></a>
        </div>
    </nav>

    <nav class="navbar navbar-expand-lg py-3 bg-white">
        <div class="container-fluid">
            <img src="../img/logo.jpg" alt="BESMAIN" style="height: 7vh;" class="mx-3">
            <a class="navbar-brand " href="studenthome.php">Bayanan Elementary School Main</a>
          <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav grid gap-3">

              <!-- HOME -->
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="studenthome.php">Home</a>
              </li>

              <!-- ENROLLMENT SERVICES -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Enrollment Services
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="enrollmentstatus.php">Enrollment Status</a></li>
                </ul>
              </li>

              <!-- EXTRA CURRICULAR -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Extra Curricular
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="sports.php">Sports</a></li>
                </ul>
              </li>

              <!-- e-Consultation -->
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="consultation.php">e-Consultation</a>
              </li>

              <!-- OTHER SERVICES -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Other Services
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="studentaccmgt.php">Account Management</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item">Student Number <br><?php echo $userid; ?></a></li>
                </ul>
              </li>
              
              <!-- LOGOUT -->
              <li class="nav-item me-3">
                <a class="nav-link" href="../logout.php" role="button">
                  Logout
                </a>
              </li>
              
            </ul>
          </div>
        </div>
    </nav>    

    <!-- MAIN -->
    <div class="container mt-5">

        <!-- Adviser Information -->
        <div class="row mb-3 mt-2 align-items-center">
            <div class="col">
                <h4 class="mb-4 text-white">Chat with Your Adviser</h4>
            </div>
            <div class="col-sm-1">
                <label class="form-label text-white fw-bold">Adviser</label>
            </div>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="adviser" id="adviser" value="<?php echo $adviser; ?>" disabled>
            </div>
        </div>

        <!-- Chat Box -->
        <div class="chat-box" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; height: 300px; max-height: 400px; overflow-y: scroll;">
        <?php while ($chat_row = $chat_result->fetch_assoc()): ?>
            <?php $sender = $chat_row['sender'] ?? 'unknown'; // Prevent undefined index ?>
            <div class="message mb-3">
                <div class="message-bubble <?php echo ($sender == 'student') ? 'student-message' : 'adviser-message'; ?>">
                    <p><strong><?php echo ($sender == 'student') ? 'You' : 'Adviser'; ?>:</strong> <?php echo $chat_row['message_text']; ?></p>
                    <small class="text-muted"><i>Sent on: <?php echo $chat_row['timestamp']; ?></i></small>
                </div>
            </div>
        <?php endwhile; ?>
        </div>

        <!-- Send Message Form -->
        <form method="POST" class="mt-4" style="max-width: 1200px; margin: 0 auto;">
            <div class="form-group">
                <textarea class="form-control" name="message_text" rows="2" placeholder="Type your message here..." required></textarea>
            </div>
            <button type="submit" name="send_message" class="btn btn-primary w-100 mt-3">Send Message</button>
        </form>
    </div>

    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="messageToast" class="toast align-items-center text-bg-<?php echo $toastType; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo $toastMessage; ?>
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    
    <hr>
    <footer>
        <div class="container-fluid row m-2 text-white">

            <div class="col-md-6">
                <p>Copyright &copy; 2024 Bayanan Elementary School Main</p>
            </div>

        </div>
    </footer>


    <!-- Script -->  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>