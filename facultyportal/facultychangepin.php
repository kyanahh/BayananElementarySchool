<?php

session_start();

require("../server/connection.php");

if(isset($_SESSION["logged_in"])){
    if(isset($_SESSION["firstname"]) || isset($_SESSION["email"])){
        $textaccount = $_SESSION["firstname"];
        $usersid = $_SESSION["userid"];
    }else{
        $textaccount = "Account";
    }
}else{
    $textaccount = "Account";
}

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usersid = $_SESSION["userid"];
    $oldpass = $_POST["oldpass"];
    $newpass = $_POST["newpass"];
    $confirmnewpass = $_POST["confirmnewpass"];

    // Fetch the current pin from the database
    $result = $connection->query("SELECT pin FROM users WHERE userid = '$usersid'");
    $record = $result->fetch_assoc();
    $stored_password = $record["pin"];

    // Check if the old password matches
    if ($oldpass == $stored_password) {
        // Check if the new pin matches the confirmation pin
        if ($newpass == $confirmnewpass) {
            // Update the pin
            $connection->query("UPDATE users SET pin = '$newpass' WHERE userid = '$usersid'");
            $errorMessage = "Password changed successfully";
        } else {
            // If new pins don't match
            $errorMessage = "New PIN numbers do not match";
        }
    } else {
        // If the old password doesn't match
        $errorMessage = "Old PIN number does not match";
    }
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
                <a class="nav-link" aria-current="page" href="facultychats.php">e-Consultation</a>
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

      <div class="w-100 justify-content-center d-flex">
        <div class="card mt-3 col-sm-9">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link text-black" href="studentaccmgt.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black active" aria-current="true" href="studentchangepin.php">Change PIN</a>
                </li>
                </ul>
            </div>
            <div class="card-body">
                <!-- Settings -->
                <div class="px-3 mt-2">
                    <form method="POST" action="<?php htmlspecialchars("SELF_PHP"); ?>">
                        <div class="row ms-2 mt-1">
                            <h2 class="fs-5">Change/Update PIN</h2>
                        </div>

                        <div class="row mb-3 ms-2 mt-2">
                            <div class="col-sm-2">
                                <label class="form-label mt-2 px-3">Current PIN Number</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" name="oldpass" id="oldpass" required>
                            </div>
                        </div>

                        <div class="row mb-3 ms-2 mt-2">
                            <div class="col-sm-2">
                                <label class="form-label mt-2 px-3">New PIN Number</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" name="newpass" id="newpass" required>
                            </div>
                        </div>

                        <div class="row mb-3 ms-2 mt-2">
                            <div class="col-sm-2">
                                <label class="form-label mt-2 px-3">Confirm New PIN Number</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="password" class="form-control" name="confirmnewpass" id="confirmnewpass" required>
                                <p class="text-danger"><?php echo $errorMessage ?></p>
                            </div>
                        </div>


                        <div class="row mb-3 mt-2 ms-5 ps-5">
                            <div class="ms-4">
                                <button type="submit" class="btn btn-dark col-sm-4 ms-5">Save</button>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- End of Settings -->
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

</body>
</html>