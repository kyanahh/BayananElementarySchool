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
    .chat-container {
        width: 80%;
        margin: auto;
        height: 300px; /* Fixed height */
        overflow-y: auto; /* Scroll if needed */
        border: 1px solid #ccc;
        padding: 10px;
        background-color: #f9f9f9;
    }
    .message {
        padding: 8px;
        border-radius: 5px;
        margin-bottom: 10px;
        max-width: 70%;
    }
    .sent {
        align-self: flex-end;
        background-color: #d1e7dd;
    }
    .received {
        align-self: flex-start;
        background-color: #f8d7da;
    }
    .timestamp {
        font-size: 0.8em;
        color: gray;
    }
</style>
<body>
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
    <!-- CHAT CONTAINER -->
    <div class="container mt-4">
        <h2 class="text-center">Faculty Chat Forum</h2>
        <div class="chat-container mt-3" id="chatBox"></div>

        <!-- Chat Input -->
        <div class="mt-3">
            <form id="chatForm">
                <div class="input-group">
                    <input type="text" id="messageInput" class="form-control" placeholder="Type a message..." required>
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </form>
        </div>
    </div>


      <hr>
      <footer>
          <div class="container-fluid row m-2">

              <div class="col-md-6">
                  <p>Copyright &copy; 2024 Bayanan Elementary School Main</p>
              </div>

          </div>
      </footer>


    <!-- Script -->  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function(){
            function fetchMessages(){
                $.ajax({
                    url: "fetch_messages.php",
                    method: "GET",
                    success: function(data){
                        $("#chatBox").html(data);
                        $("#chatBox").scrollTop($("#chatBox")[0].scrollHeight);
                    }
                });
            }

            $("#chatForm").submit(function(e){
                e.preventDefault();
                var message = $("#messageInput").val().trim();

                if (message === "") {
                    alert("Message cannot be empty.");
                    return;
                }

                $.ajax({
                    url: "send_message.php",
                    method: "POST",
                    data: { message: message },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $("#messageInput").val("");
                            fetchMessages();
                        } else {
                            alert("Error: " + response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("AJAX error: " + error);
                    }
                });
            });

            fetchMessages();
            setInterval(fetchMessages, 3000);
        });
    </script>

</body>
</html>