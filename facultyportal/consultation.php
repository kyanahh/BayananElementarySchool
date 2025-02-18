<?php

session_start();

require("../server/connection.php");

if(isset($_SESSION["logged_in"])){
    if(isset($_SESSION["firstname"]) || isset($_SESSION["email"])){
        $textaccount = $_SESSION["firstname"] ?? "Account";
        $usersid = $_SESSION["userid"] ?? "";
    }else{
        $textaccount = "Account";
    }
}else{
    $textaccount = "Account";
}

$adviser_id = $_SESSION["userid"];

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
        body { background-color: #f8f9fa; }
        .chat-container { display: flex; height: 500px; }
        .chat-list { width: 30%; overflow-y: auto; border-right: 1px solid #ddd; }
        .chat-box { width: 70%; display: flex; flex-direction: column; }
        .messages { flex-grow: 1; overflow-y: auto; padding: 10px; }
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
            <a class="navbar-brand " href="parenthome.php">Bayanan Elementary School Main</a>
          <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav grid gap-3">

              <!-- HOME -->
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="facultyhome.php">Home</a>
              </li>

              <!-- PTA -->
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="facultypta.php">PTA</a>
              </li>

              <!-- e-Consultation-->
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="facultychats.php">Forum</a>
              </li>

              <!-- e-Consultation-->
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="consultation.php">e-Consultation</a>
              </li>

              <!-- OTHER SERVICES -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Other Services
                </a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="facultyaccmgt.php">Account Management</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item">Logged in as:</a></li>
                  <li><a class="dropdown-item"><?php echo $usersid; ?></a></li>
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
        <h2 class="text-center fw-bold text-white">Conversations</h2>
            <div class="card mt-3">
                <div class="chat-container">
                    <div class="chat-list p-3">
                        <h5>Conversations</h5>
                        <ul class="list-group" id="conversation-list">
                        </ul>
                    </div>
                    <div class="chat-box">
                        <div class="messages p-3" id="chat-box">
                            <p class="text-muted">Select a conversation</p>
                        </div>
                        <div class="card-footer">
                            <div class="input-group">
                                <input type="text" id="reply_message" class="form-control" placeholder="Type your reply...">
                                <button class="btn btn-primary" id="send_reply">Send</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <hr class="mt-5">
    <footer>
        <div class="container-fluid row m-2 text-white">

            <div class="col-md-6">
                <p>Copyright &copy; 2024 Bayanan Elementary School Main</p>
            </div>

        </div>
    </footer>


    <!-- Script -->  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function () {
            function loadConversations() {
                $.ajax({
                    url: "get_conversations.php",
                    method: "GET",
                    data: { adviser_id: <?php echo $adviser_id; ?> },
                    success: function (data) {
                        $("#conversation-list").html(data);
                    }
                });
            }

            function loadMessages(conversation_id) {
                $.ajax({
                    url: "get_chat_messages.php",
                    method: "GET",
                    data: { conversation_id: conversation_id },
                    success: function (data) {
                        $("#chat-box").html(data);
                        $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
                    }
                });
            }

            loadConversations();
            
            // Make sure the click event works
            $(document).on("click", ".conversation-item", function () {
                let conversation_id = $(this).data("conversation-id");
                $(".conversation-item").removeClass("active");
                $(this).addClass("active");
                loadMessages(conversation_id);
            });

            $(document).on("click", "#send_reply", function () {
                let message = $("#reply_message").val().trim();
                let conversation_id = $(".conversation-item.active").data("conversation-id"); 

                if (message !== "" && conversation_id) {
                    $.ajax({
                        url: "send_chat_reply.php",
                        method: "POST",
                        data: { conversation_id: conversation_id, message_text: message },
                        dataType: "json",
                        success: function (response) {
                            if (response.status === "success") {
                                $("#reply_message").val("");
                                loadMessages(conversation_id);
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log("AJAX Error:", status, error);
                            console.log("Response:", xhr.responseText);
                            alert("Failed to send message.");
                        }
                    });
                } else {
                    alert("Message cannot be empty!");
                }
            });
        });
    </script>

</body>
</html>